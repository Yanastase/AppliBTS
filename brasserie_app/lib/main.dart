import 'package:flutter/material.dart';
import 'package:brasserie_app/api_service.dart';
import 'package:shared_preferences/shared_preferences.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Brasserie App',
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(seedColor: Colors.deepPurple),
        useMaterial3: true,
      ),
      home: const HomePage(),
    );
  }
}

class HomePage extends StatelessWidget {
  const HomePage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Brasserie Terroire et savoir'),
      ),
      drawer: Drawer(
        child: FutureBuilder<int?>(
          future: _getLoggedInUserId(),
          builder: (context, snapshot) {
            final isLoggedIn = snapshot.data != null;

            return ListView(
              padding: EdgeInsets.zero,
              children: [
                DrawerHeader(
                  decoration: BoxDecoration(
                    color: const Color.fromARGB(255, 215, 162, 55),
                  ),
                  child: const Text(
                    'Brasserie App',
                    style: TextStyle(
                      color: Color.fromARGB(255, 255, 255, 255),
                      fontSize: 24,
                    ),
                  ),
                ),
                ListTile(
                  leading: const Icon(Icons.home),
                  title: const Text('Home'),
                  onTap: () {
                    Navigator.pop(context);
                    Navigator.push(
                      context,
                      MaterialPageRoute(builder: (context) => const HomePage()),
                    );
                  },
                ),
                ListTile(
                  leading: const Icon(Icons.list),
                  title: const Text('Boisson List'),
                  onTap: () {
                    Navigator.pop(context);
                    Navigator.push(
                      context,
                      MaterialPageRoute(builder: (context) => const ListPage()),
                    );
                  },
                ),
                if (isLoggedIn) // Show "Reservation" only if logged in
                  ListTile(
                    leading: const Icon(Icons.calendar_today),
                    title: const Text('Reservation'),
                    onTap: () {
                      Navigator.pop(context);
                      Navigator.push(
                        context,
                        MaterialPageRoute(builder: (context) => const ReservationPage()),
                      );
                    },
                  ),
                ListTile(
                  leading: Icon(isLoggedIn ? Icons.logout : Icons.login),
                  title: Text(isLoggedIn ? 'Logout' : 'Login'),
                  onTap: () async {
                    Navigator.pop(context);
                    if (isLoggedIn) {
                      // Logout logic
                      final prefs = await SharedPreferences.getInstance();
                      await prefs.remove('user_id');
                      ScaffoldMessenger.of(context).showSnackBar(
                        const SnackBar(content: Text('Logged out successfully')),
                      );
                      Navigator.pushReplacement(
                        context,
                        MaterialPageRoute(builder: (context) => const HomePage()),
                      );
                    } else {
                      // Navigate to LoginPage
                      Navigator.push(
                        context,
                        MaterialPageRoute(builder: (context) => const LoginPage()),
                      );
                    }
                  },
                ),
              ],
            );
          },
        ),
      ),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Image.asset(
              'assets/images/brasserie_logo.png',
              width: 300,
              height: 300,
            ),
            const SizedBox(height: 20),
            const Text(
              'Bienvenue dans notre Brasserie Terroire et savoir!',
              style: TextStyle(
                fontSize: 24,
                fontWeight: FontWeight.bold,
              ),
              textAlign: TextAlign.center,
            ),
            const SizedBox(height: 10),
            const Text(
              ' Ici, nous brassons des bières artisanales avec passion et savoir-faire. Notre mission ? Vous offrir une expérience gustative unique, dans un esprit de convivialité et de partage.',
              style: TextStyle(fontSize: 16),
              textAlign: TextAlign.center,
            ),
          ],
        ),
      ),
    );
  }

  Future<int?> _getLoggedInUserId() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getInt('user_id');
  }
}

class ListPage extends StatefulWidget {
  const ListPage({super.key});

  @override
  State<ListPage> createState() => _ListPageState();
}

class _ListPageState extends State<ListPage> {
  final ApiService _apiService = ApiService();
  late Future<List<dynamic>> _boissons;
  int? _numCompte;

  @override
  void initState() {
    super.initState();
    _boissons = _apiService.fetchBoissonList();
    _loadUserData();
  }

  Future<void> _loadUserData() async {
    final prefs = await SharedPreferences.getInstance();
    setState(() {
      _numCompte = prefs.getInt('user_id');
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Nos differents breuvages'),
      ),
      body: FutureBuilder<List<dynamic>>(
        future: _boissons,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Center(child: CircularProgressIndicator());
          } else if (snapshot.hasError) {
            return Center(child: Text('Error: ${snapshot.error}'));
          } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
            return const Center(child: Text('No boissons available'));
          } else {
            return ListView.builder(
              itemCount: snapshot.data!.length,
              itemBuilder: (context, index) {
                final boisson = snapshot.data![index];
                return ListTile(
                  title: Text((boisson?['nom'] as String?) ?? 'Unknown Name'),
                  subtitle: Text('Prix: ${boisson['prix']}€'),
                  trailing: _numCompte != null
                      ? TextButton(
                          onPressed: () async {
                            try {
                              final int numBoisson = boisson['id'];
                              const int quantity = 1;

                              // Check if a reservation already exists
                              final existingReservations = await _apiService.fetchPanierList();
                              final existingReservation = existingReservations.firstWhere(
                                (reservation) =>
                                    reservation['NumCompte']?['id'] == _numCompte &&
                                    reservation['Boisson']?['id'] == numBoisson,
                                orElse: () => null,
                              );

                              if (existingReservation != null) {
                                // Update quantity
                                final updatedQuantity =
                                    existingReservation['Quantity'] + quantity;
                                await _apiService.updatePanier(
                                  existingReservation['id'],
                                  updatedQuantity,
                                );
                              } else {
                                // Add new reservation
                                await _apiService.addToPanier(quantity, _numCompte!, numBoisson);
                              }

                              ScaffoldMessenger.of(context).showSnackBar(
                                SnackBar(
                                  content: Text('Reservation for ${boisson['nom']} added!'),
                                ),
                              );
                            } catch (e) {
                              ScaffoldMessenger.of(context).showSnackBar(
                                SnackBar(
                                  content: Text('Failed to reserve: $e'),
                                ),
                              );
                            }
                          },
                          style: TextButton.styleFrom(
                            backgroundColor: Colors.lightBlue,
                            foregroundColor: Colors.white,
                          ),
                          child: const Text('Reserver'),
                        )
                      : null,
                );
              },
            );
          }
        },
      ),
    );
  }
}

class LoginPage extends StatefulWidget {
  const LoginPage({super.key});

  @override
  State<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  final ApiService _apiService = ApiService();
  final TextEditingController _emailController = TextEditingController();
  final TextEditingController _passwordController = TextEditingController();
  bool _isLoading = false;
  String? _errorMessage;

  Future<void> _login() async {
    setState(() {
      _isLoading = true;
      _errorMessage = null;
    });

    try {
      final response = await _apiService.authenticate(
        _emailController.text,
        _passwordController.text,
      );

      final prefs = await SharedPreferences.getInstance();
      prefs.setInt('user_id', response['userId']); // Save the logged-in user's numCompte

      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Welcome, User ID: ${response['userId']}')),
        );

        Navigator.pushReplacement(
          context,
          MaterialPageRoute(builder: (context) => const HomePage()),
        );
      }
    } catch (e) {
      setState(() {
        _errorMessage = e.toString();
      });
    } finally {
      setState(() {
        _isLoading = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Login'),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            TextField(
              controller: _emailController,
              decoration: const InputDecoration(labelText: 'Email'),
              keyboardType: TextInputType.emailAddress,
            ),
            TextField(
              controller: _passwordController,
              decoration: const InputDecoration(labelText: 'Password'),
              obscureText: true,
            ),
            const SizedBox(height: 20),
            if (_isLoading)
              const CircularProgressIndicator()
            else
              ElevatedButton(
                onPressed: _login,
                child: const Text('Login'),
              ),
            if (_errorMessage != null)
              Padding(
                padding: const EdgeInsets.only(top: 20),
                child: Text(
                  _errorMessage!,
                  style: const TextStyle(color: Colors.red),
                ),
              ),
          ],
        ),
      ),
    );
  }
}

class ReservationPage extends StatefulWidget {
  const ReservationPage({super.key});

  @override
  State<ReservationPage> createState() => _ReservationPageState();
}

class _ReservationPageState extends State<ReservationPage> {
  final ApiService _apiService = ApiService();
  Future<List<dynamic>>? _reservations; // Make it nullable to handle initialization
  int? _numCompte; // Store the logged-in user's numCompte

  @override
  void initState() {
    super.initState();
    _loadUserData();
  }

  Future<void> _loadUserData() async {
    final prefs = await SharedPreferences.getInstance();
    setState(() {
      _numCompte = prefs.getInt('user_id'); // Retrieve the logged-in user's numCompte
    });
    // Fetch reservations after loading user data
    _reservations = _fetchFilteredReservations();
  }

  Future<List<dynamic>> _fetchFilteredReservations() async {
    final allReservations = await _apiService.fetchPanierList();
    // Filter reservations to only include those with the same NumCompte as the logged-in user
    return allReservations.where((reservation) {
      return reservation['NumCompte']?['id'] == _numCompte;
    }).toList();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Vos reservations'),
      ),
      body: _reservations == null
          ? const Center(child: CircularProgressIndicator()) // Show a loading indicator until _reservations is initialized
          : FutureBuilder<List<dynamic>>(
              future: _reservations,
              builder: (context, snapshot) {
                if (snapshot.connectionState == ConnectionState.waiting) {
                  return const Center(child: CircularProgressIndicator());
                } else if (snapshot.hasError) {
                  return Center(child: Text('Error: ${snapshot.error}'));
                } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
                  return const Center(child: Text('No reservations available'));
                } else {
                  final reservations = snapshot.data!;
                  final double totalPrice = reservations.fold(0.0, (sum, reservation) {
                    final int quantity = reservation['Quantity'] ?? 1;
                    final double price = double.tryParse(
                            reservation['Boisson']?['prix']?.toString() ?? '0') ??
                        0.0;
                    return sum + (price * quantity);
                  });

                  return Column(
                    children: [
                      Expanded(
                        child: ListView.builder(
                          itemCount: reservations.length,
                          itemBuilder: (context, index) {
                            final reservation = reservations[index];
                            final int quantity = reservation['Quantity'] ?? 1;

                            // Safely parse the price as a double
                            final double price = double.tryParse(
                                    reservation['Boisson']?['prix']?.toString() ?? '0') ??
                                0.0;
                            final double totalItemPrice = price * quantity;

                            return ListTile(
                              title: Text(reservation['Boisson']?['nom'] ?? 'Unknown Boisson'),
                              subtitle: Text('Quantité: $quantity'),
                              trailing: Text('Total: ${totalItemPrice.toStringAsFixed(2)}€'),
                            );
                          },
                        ),
                      ),
                      Container(
                        padding: const EdgeInsets.all(16.0),
                        color: Colors.grey[200],
                        child: Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            const Text(
                              'Prix total:',
                              style: TextStyle(
                                fontSize: 18,
                                fontWeight: FontWeight.bold,
                              ),
                            ),
                            Text(
                              '${totalPrice.toStringAsFixed(2)}€',
                              style: const TextStyle(
                                fontSize: 18,
                                fontWeight: FontWeight.bold,
                              ),
                            ),
                          ],
                        ),
                      ),
                    ],
                  );
                }
              },
            ),
    );
  }
}