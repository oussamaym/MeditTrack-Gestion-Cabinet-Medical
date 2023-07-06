import 'package:flutter/material.dart';

class DossierScreen extends StatelessWidget {
  final List<Map<String, String>> items = [
    {
      'description': 'Item 1 Description',
      'fichier': 'Item 1 Fichier',
    },
    {
      'description': 'Item 2 Description',
      'fichier': 'Item 2 Fichier',
    },
    {
      'description': 'Item 3 Description',
      'fichier': 'Item 3 Fichier',
    },
    // Add more items as needed
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Dossier Screen'),
      ),
      body: Container(
        color: Color.fromARGB(248, 12, 155, 143),
        padding: EdgeInsets.all(16.0),
        child: ListView.builder(
          itemCount: items.length,
          itemBuilder: (context, index) {
            final item = items[index];
            return Card(
              child: ListTile(
                title: Text(item['description'] ?? ''),
                subtitle: Text(item['fichier'] ?? ''),
              ),
            );
          },
        ),
      ),
    );
  }
}
