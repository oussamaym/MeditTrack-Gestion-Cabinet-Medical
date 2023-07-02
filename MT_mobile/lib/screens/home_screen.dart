import 'dart:convert';

import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:healthcare/main.dart';
import 'package:healthcare/providers/dio_provider.dart';
import 'package:healthcare/providers/user_provider.dart';
import 'package:healthcare/screens/appointment_screen.dart';
import 'package:healthcare/screens/messages_screen.dart';
import 'package:healthcare/screens/settings_screen.dart';
import 'package:provider/provider.dart';
import 'package:shared_preferences/shared_preferences.dart';

class homeScreen extends StatefulWidget {
  @override
  State<homeScreen> createState() => _homeScreenState();
}

class _homeScreenState extends State<homeScreen> {
  String patientImageUrl = '';
  Set<dynamic> medecins = {};

  List<String> symptoms = [
    //in french
    "Douleur",
    "Toux",
    "Fièvre",
    "Maux de tête",
    "Maux de gorge",
    "Fatigue",
    "Essoufflement",
    "Perte de goût ou d'odorat",
    "Congestion nasale",
    "Nausées ou vomissements",
    "Diarrhée",
  ];

  List<String> imgs = [
    "doctor1.jpg",
    "doctor2.jpg",
    "doctor3.jpg",
    "doctor4.jpg",
  ];

  Future<void> getUserData() async {
  final SharedPreferences prefs = await SharedPreferences.getInstance();
  final token = prefs.getString('token') ?? '';
  if (token.isNotEmpty && token != '') {
    final response = await DioProvider().getUser(token);
    if (mounted) {
      // Check if the widget is still mounted before updating the state
      if (response != null) {
        final user = json.decode(response);
        final String baseUrl = 'http://10.0.2.2:8000/storage/';
        final String image_path = user['photo'];
        setState(() {
          patientImageUrl = baseUrl + image_path;
        });

        final userProvider = Provider.of<UserProvider>(context, listen: false);
        userProvider.updateUser(user);
      }
    }
  }
}

 Future<void> getMedecinData() async {
  final SharedPreferences prefs = await SharedPreferences.getInstance();
  final token = prefs.getString('token') ?? '';
  if (token.isNotEmpty && token != '') {
    final response = await DioProvider().getDoctors(token);
     if (mounted) {
      // Check if the widget is still mounted before updating the state
      if (response != null) {
        setState(() {
          medecins = Set.from(response);
        });
      }
    }
  }
}
  @override
  void initState() {
    getUserData();
    getMedecinData();

    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Consumer<UserProvider>(
      builder: (context, userProvider, _) {
        final user = userProvider.user;
        return SingleChildScrollView(
          child: user.isEmpty
              ? Container(
                  height: MediaQuery.of(context).size.height,
                  width: MediaQuery.of(context).size.width,
                  child: Center(
                    child: CircularProgressIndicator(),
                  ),
                )
              : Padding(
                  padding: const EdgeInsets.only(top: 40),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Padding(
                        padding: const EdgeInsets.symmetric(horizontal: 15),
                        child: Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            Text(
                              '${user['nom'][0].toUpperCase()}${user['nom'].substring(1)} ${user['prenom'][0].toUpperCase()}${user['prenom'].substring(1)}',
                              style: TextStyle(
                                fontSize: 25,
                                fontWeight: FontWeight.w500,
                              ),
                            ),
                Stack(
  children: [
    CircleAvatar(
      radius: 25,
      backgroundImage: patientImageUrl.isNotEmpty
          ? NetworkImage(patientImageUrl) as ImageProvider
          : null,
    ),
    if (patientImageUrl.isEmpty)
      Positioned.fill(
        child: Container(
          color: Colors.white,
          child: Center(
            child: CircularProgressIndicator(
              color: Colors.grey,
            ),
          ),
        ),
      ),
  ],
),

                          ],
                        ),
                      ),
                      SizedBox(height: 30),
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                children: [
                  InkWell(
                    onTap: () {},
                    child: Container(
                      padding: EdgeInsets.all(20),
                      decoration: BoxDecoration(
                        color: Color.fromARGB(248, 12, 155, 143),
                        borderRadius: BorderRadius.circular(10),
                        boxShadow: [
                          BoxShadow(
                            color: Colors.black12,
                            blurRadius: 6,
                            spreadRadius: 4,
                          ),
                        ],
                      ),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Container(
                            padding: EdgeInsets.all(8),
                            decoration: BoxDecoration(
                              color: Colors.white,
                              shape: BoxShape.circle,
                            ),
                            child: Icon(
                              Icons.add,
                              color: Color.fromARGB(248, 12, 155, 143),
                              size: 35,
                            ),
                          ),
                          SizedBox(height: 30),
                          Text(
                            "Visite à la clinique",
                            style: TextStyle(
                              fontSize: 18,
                              color: Colors.white,
                              fontWeight: FontWeight.w500,
                            ),
                          ),
                          SizedBox(height: 5),
                          Text(
                            "Prendre un rendez-vous",
                            style: TextStyle(
                              color: Colors.white54,
                            ),
                          ),
                        ],
                      ),
                    ),
                  ),
                  InkWell(
                    onTap: () {},
                    child: Container(
                      padding: EdgeInsets.all(20),
                      decoration: BoxDecoration(
                        color: Colors.white,
                        borderRadius: BorderRadius.circular(10),
                        boxShadow: [
                          BoxShadow(
                            color: Colors.black12,
                            blurRadius: 6,
                            spreadRadius: 4,
                          ),
                        ],
                      ),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Container(
                            padding: EdgeInsets.all(8),
                            decoration: BoxDecoration(
                              color: Color(0xFFF0EEFA),
                              shape: BoxShape.circle,
                            ),
                            child: Icon(
                              Icons.home_filled,
                              color: Color.fromARGB(248, 12, 155, 143),
                              size: 35,
                            ),
                          ),
                          SizedBox(height: 30),
                          Text(
                            "Visite à domicile",
                            style: TextStyle(
                              fontSize: 18,
                              color: Colors.black,
                              fontWeight: FontWeight.w500,
                            ),
                          ),
                          SizedBox(height: 5),
                          Text(
                            "Appeler un médecin",
                            style: TextStyle(
                              color: Colors.black54,
                            ),
                          ),
                        ],
                      ),
                    ),
                  ),
                ],
              ),
              SizedBox(height: 25),
              Padding(
                padding: const EdgeInsets.only(left: 15),
                child: Text(
                  "Quels sont vos symptômes ?",
                  style: TextStyle(
                    fontSize: 23,
                    fontWeight: FontWeight.w500,
                    color: Colors.black54,
                  ),
                ),
              ),
              SizedBox(
                height: 70,
                child: ListView.builder(
                  shrinkWrap: true,
                  scrollDirection: Axis.horizontal,
                  itemCount: symptoms.length,
                  itemBuilder: (context, index) {
                    return Container(
                      margin:
                          EdgeInsets.symmetric(horizontal: 15, vertical: 10),
                      padding: EdgeInsets.symmetric(horizontal: 25),
                      decoration: BoxDecoration(
                        color: Color(0xFFF4F6FA),
                        borderRadius: BorderRadius.circular(10),
                        boxShadow: [
                          BoxShadow(
                            color: Colors.black12,
                            blurRadius: 4,
                            spreadRadius: 2,
                          ),
                        ],
                      ),
                      child: Center(
                        child: Text(
                          symptoms[index],
                          style: TextStyle(
                            fontSize: 16,
                            fontWeight: FontWeight.w500,
                            color: Colors.black54,
                          ),
                        ),
                      ),
                    );
                  },
                ),
              ),
              SizedBox(height: 15),
              Padding(
                padding: const EdgeInsets.only(left: 15),
                child: Text(
                  "Nos Medecins",
                  style: TextStyle(
                    fontSize: 23,
                    fontWeight: FontWeight.w500,
                    color: Colors.black54,
                  ),
                ),
              ),
              GridView.builder(
                gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                  crossAxisCount: 2,
                ),
                itemCount: medecins.length,
                shrinkWrap: true,
                physics: NeverScrollableScrollPhysics(),
                itemBuilder: (context, index) {
                   var medecin = medecins.elementAt(index);
                  var medecinImageurl="http://10.0.2.2:8000/storage/"+medecin['photo'];
                  return InkWell(
                 onTap: () {
  Navigator.of(context).pushNamed('booking_page',arguments:{"medecin_id":medecin['id']});
},
                    child: Container(
                      margin: EdgeInsets.all(10),
                      padding: EdgeInsets.symmetric(vertical: 15),
                      decoration: BoxDecoration(
                        color: Colors.white,
                        borderRadius: BorderRadius.circular(10),
                        boxShadow: [
                          BoxShadow(
                            color: Colors.black12,
                            blurRadius: 4,
                            spreadRadius: 2,
                          ),
                        ],
                      ),
                      child: Column(
                        mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                        children: [
                           Stack(
                        children: [
                        CircleAvatar(
                        radius: 35,
      backgroundImage: medecinImageurl.isNotEmpty
          ? NetworkImage(medecinImageurl) as ImageProvider
          : null,
    ),
    if (medecinImageurl.isEmpty)
      Positioned.fill(
        child: Container(
          color: Colors.white,
          child: Center(
            child: CircularProgressIndicator(
              color: Colors.grey,
            ),
          ),
        ),
      ),
  ],
),
                         Text(
                            "Dr. "+medecin['nom']+" "+medecin['prenom']+"",
                            textAlign: TextAlign.center,
                            style: TextStyle(
                              fontSize: 18,
                              fontWeight: FontWeight.w500,
                              color: Colors.black54,
                              
                            ),
                          ),
                          Text(
                            medecin['specialite'],
                            style: TextStyle(
                              color: Colors.black45,
                            ),
                          ),
                          Row(
                            mainAxisSize: MainAxisSize.min,
                            mainAxisAlignment: MainAxisAlignment.center,
                            children: [
                              Icon(
                                Icons.star,
                                color: Colors.amber,
                              ),
                              Text(
                                "4.9",
                                style: TextStyle(
                                  color: Colors.black45,
                                ),
                              ),
                            ],
                          ),
                        ],
                      ),
                    ),
                  );
                },
              ),
            ],
          ),
        ),
      
    );
      }
    );
  }
}
