import 'dart:io';
import 'package:flutter/material.dart';
import 'package:healthcare/main.dart';
import 'package:healthcare/providers/dio_provider.dart';
import 'package:healthcare/providers/user_provider.dart';
import 'package:healthcare/screens/success_filled.dart';
import 'package:image_picker/image_picker.dart';
import 'package:provider/provider.dart';
import 'package:shared_preferences/shared_preferences.dart';

class MedicalFileScreen extends StatefulWidget {
  @override
  _MedicalFileScreenState createState() => _MedicalFileScreenState();
}

class _MedicalFileScreenState extends State<MedicalFileScreen> {
  TextEditingController _descriptionController = TextEditingController();
  String? token;

  File? _selectedFile;
  Future _pickFile() async {
    final pickedFile = await ImagePicker().pickImage(source: ImageSource.gallery);
    setState(() {
      if (pickedFile != null) {
        _selectedFile = File(pickedFile.path);
      }
    });
  }
   


  Future<void> getToken() async {
    final SharedPreferences prefs = await SharedPreferences.getInstance();
    token = prefs.getString('token') ?? '';
  }

  @override
  void initState() {
    getToken();
    super.initState();
  }

  @override
  void dispose() {
    _descriptionController.dispose();
    super.dispose();
  }
  

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Dossier médical'),
        backgroundColor: Color.fromARGB(255, 12, 155, 143),
      ),
      body: Padding(
        padding: EdgeInsets.all(16.0),
        child: SingleChildScrollView(
  child: Column(
    crossAxisAlignment: CrossAxisAlignment.stretch,
    children: [
      TextField(
        controller: _descriptionController,
        decoration: InputDecoration(
          labelText: 'Description',
        ),
      ),
      SizedBox(height: 16.0),
      ElevatedButton(
        onPressed: _pickFile,
        child: Text('Choisir un fichier'),
        style: ButtonStyle(
          backgroundColor: MaterialStateProperty.all<Color>(
            Color.fromARGB(255, 12, 155, 143),
          ),
        ),
      ),
      SizedBox(height: 16.0),
      Text(
        _selectedFile != null ? 'Fichier sélectionné : ${_selectedFile!.path}' : 'Aucun fichier sélectionné',
        style: TextStyle(
          fontSize: 16.0,
        ),
      ),
      SizedBox(height: 16.0),
      Consumer<UserProvider>(
        builder: (context, userProvider, _) {
          final user = userProvider.user;
          return ElevatedButton(
            onPressed: () async {
              // Save the values
              String description = _descriptionController.text;
              //String fileName = _selectedFile != null ? _selectedFile.path.split('/').last : '';
              String filePath = 'fichiers/patients';

              final remplissage = await DioProvider().ajouterDM(
                description, filePath, _selectedFile, user['id'], token!,
              );
              
              if (remplissage == 200) {
                MyApp.navigatorKey.currentState!.push(MaterialPageRoute(
                  builder: (context) => SucessFilledScreen(),
                ));
              }
            },
            child: Text('Envoyer'),
            style: ButtonStyle(
              backgroundColor: MaterialStateProperty.all<Color>(
                Color.fromARGB(255, 12, 155, 143),
              ),
            ),
          );
        },
      ),
    ],
  ),
),
      ),
    );
  }
}
