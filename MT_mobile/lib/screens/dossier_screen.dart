import 'package:flutter/material.dart';
import 'package:healthcare/providers/dio_provider.dart';
import 'package:healthcare/providers/user_provider.dart';
import 'package:provider/provider.dart';
import 'package:shared_preferences/shared_preferences.dart';

class PatientMedicalRecordScreen extends StatefulWidget {
  @override
  State<PatientMedicalRecordScreen> createState() => _PatientMedicalRecordScreenState();
}

class _PatientMedicalRecordScreenState extends State<PatientMedicalRecordScreen> {
  final List<String> imageDescriptions = [
    'Description de l\'image 1',
    'Description de l\'image 2',
    'Description de l\'image 3',
    // Ajoutez d'autres descriptions ici
  ];
  final String baseUrl = 'http://10.0.2.2:8000/storage/';
     UserProvider? userProvider;
   


Set<dynamic> dossiers = {};
@override
  void didChangeDependencies() {
    super.didChangeDependencies();
    
    // Retrieve the user provider
    userProvider = Provider.of<UserProvider>(context);
    
    // Call your function that needs to access the user provider
    getDossiersData();
  }

 Future<void> getDossiersData() async {
  final SharedPreferences prefs = await SharedPreferences.getInstance();
  final token = prefs.getString('token') ?? '';
 final user = userProvider!.user;
  if (token.isNotEmpty && token != '') {
    final response = await DioProvider().getDossier(user['id'],token);
     if (mounted) {
      // Check if the widget is still mounted before updating the state
      if (response != null) {
        setState(() {
          dossiers = Set.from(response);
        });
      }
    }
  }
}
@override
  void initState() {
   
   getDossiersData();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Color.fromARGB(248, 12, 155, 143),
      body: dossiers.isEmpty
              ? Container(
                  height: MediaQuery.of(context).size.height,
                  width: MediaQuery.of(context).size.width,
                  child: Center(
                    child: CircularProgressIndicator(),
                  ),
                )
              :  SafeArea(
        child: Padding(
          padding: EdgeInsets.all(16.0),
             child : Consumer<UserProvider>(
              builder: (context, userProvider, _) {
                final user = userProvider.user;
          return Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                '${user['nom'][0].toUpperCase()}${user['nom'].substring(1)} ${user['prenom'][0].toUpperCase()}${user['prenom'].substring(1)}',
                style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold, color: Colors.white),
              ),
              SizedBox(height: 16.0),
              Expanded(
                child: ListView.builder(
                  itemCount: dossiers.length,
                  itemBuilder: (context, index) {
                     var dossier = dossiers.elementAt(index);
                  var dossierurl=baseUrl+dossier['fichier'];
                    return Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Container(
                          height: 200,
                          width: double.infinity,
                          decoration: BoxDecoration(
                            borderRadius: BorderRadius.circular(10),
                            color: Colors.white,
                            boxShadow: [
                              BoxShadow(
                                color: Colors.black.withOpacity(0.2),
                                blurRadius: 4.0,
                                offset: Offset(0, 2),
                              ),
                            ],
                          ),
                child: Image.network(
  dossierurl,
  fit: BoxFit.cover,
  loadingBuilder: (BuildContext context, Widget child, ImageChunkEvent? loadingProgress) {
    if (loadingProgress == null)
      return child;
    return Center(
      child: CircularProgressIndicator(
        value: loadingProgress.expectedTotalBytes != null
            ? loadingProgress.cumulativeBytesLoaded / loadingProgress.expectedTotalBytes!
            : null,
      ),
    );
  },
  errorBuilder: (context, error, stackTrace) {
    // Display "Pas de fichier" text when image cannot be loaded
    return Center(
      child: Text(
        'Pas de fichier',
        style: TextStyle(
          fontSize: 16,
          fontWeight: FontWeight.bold,
        ),
      ),
    );
  },
),



                        ),
                        SizedBox(height: 8.0),
                        Padding(
                          padding: EdgeInsets.symmetric(horizontal: 8.0),
                          child: Text(
                            'Description : '+dossier['description'],
                            style: TextStyle(fontSize: 16, color: Colors.white),
                          ),
                        ),
                        SizedBox(height: 16.0),
                      ],
                    );
                  },
                ),
              ),
            ],
          );
              },
             ),
        ),
      ),
    );
  }
}