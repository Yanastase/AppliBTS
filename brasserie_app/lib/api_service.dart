import 'dart:convert';
import 'package:http/http.dart' as http;

class ApiService {
  final String baseUrl = 'http://localhost:8000'; // Replace with your API's base URL

  Future<dynamic> fetchData(String endpoint) async {
    final url = Uri.parse('$baseUrl/$endpoint');
    try {
      final response = await http.get(url);
      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      } else {
        throw Exception('Failed to load data: ${response.statusCode}');
      }
    } catch (e) {
      throw Exception('Error: $e');
    }
  }

  Future<List<dynamic>> fetchBoissonList() async {
    final url = Uri.parse('$baseUrl/boissonList'); // Ensure the endpoint matches your Symfony route
    try {
      final response = await http.get(url);
      if (response.statusCode == 200) {
        return jsonDecode(response.body); // Parse the JSON response
      } else {
        throw Exception('Failed to load boissons: ${response.statusCode}');
      }
    } catch (e) {
      throw Exception('Error: $e');
    }
  }

  Future<Map<String, dynamic>> authenticate(String email, String password) async {
    final url = Uri.parse('$baseUrl/auth'); // Ensure the endpoint matches your Symfony route
    try {
      final response = await http.post(
        url,
        headers: {'Content-Type': 'application/json'},
        body: jsonEncode({'email': email, 'password': password}),
      );
      if (response.statusCode == 200) {
        return jsonDecode(response.body); // Parse the JSON response
      } else {
        throw Exception('Authentication failed: ${response.statusCode}');
      }
    } catch (e) {
      throw Exception('Error: $e');
    }
  }

  Future<void> addToPanier(int quantity, int numCompte, int numBoisson) async {
    final url = Uri.parse('$baseUrl/panieradd');
    try {
      final response = await http.post(
        url,
        headers: {'Content-Type': 'application/json'},
        body: jsonEncode({
          'quantity': quantity,
          'numCompte': numCompte,
          'numBoisson': numBoisson,
        }),
      );
      if (response.statusCode != 201) {
        throw Exception('Failed to add to panier: ${response.statusCode}');
      }
    } catch (e) {
      throw Exception('Error: $e');
    }
  }

  Future<List<dynamic>> fetchPanierList() async {
    final url = Uri.parse('$baseUrl/panierList');
    try {
      final response = await http.get(url);
      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      } else {
        throw Exception('Failed to fetch panier list: ${response.statusCode}');
      }
    } catch (e) {
      throw Exception('Error: $e');
    }
  }

  Future<void> updatePanier(int panierId, int quantity) async {
    final url = Uri.parse('$baseUrl/panier/$panierId');
    try {
      final response = await http.put(
        url,
        headers: {'Content-Type': 'application/json'},
        body: jsonEncode({'quantity': quantity}),
      );
      if (response.statusCode != 200) {
        throw Exception('Failed to update panier: ${response.statusCode}');
      }
    } catch (e) {
      throw Exception('Error: $e');
    }
  }
}