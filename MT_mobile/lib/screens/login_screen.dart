import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:healthcare/main.dart';
import 'package:healthcare/models/auth_model.dart';
import 'package:healthcare/providers/dio_provider.dart';
import 'package:healthcare/widgets/navbar_roots.dart';
import 'package:provider/provider.dart';
import 'package:fluttertoast/fluttertoast.dart';

class loginScreen extends StatefulWidget {
  @override
  State<loginScreen> createState() => _loginScreenState();
}

class _loginScreenState extends State<loginScreen> {
  bool passToggle = true;
  TextEditingController _emailController = TextEditingController();
 TextEditingController _passwordController = TextEditingController();
  @override
  Widget build(BuildContext context) {
    return Material(
      color: Colors.white,
      child: SingleChildScrollView(
        child: SafeArea(
          child: Column(
            children: [
              SizedBox(height: 10),
              Padding(
                padding: const EdgeInsets.all(20),
                child: Image.asset(
                  "images/doctors.png",
                ),
              ),
              SizedBox(height: 10),
              Padding(
                padding: const EdgeInsets.all(12),
                child: TextField(
                  controller: _emailController, 
                  decoration: InputDecoration(
                    border: OutlineInputBorder(),
                    label: Text("Entrez votre adresse electronique"),
                    prefixIcon: Icon(Icons.person),
                  ),
                ),
              ),
              Padding(
                padding: const EdgeInsets.all(12),
                child: TextField(
                  controller: _passwordController,
                  obscureText: passToggle ? true : false,
                  decoration: InputDecoration(
                    border: OutlineInputBorder(),
                    label: Text("Entrez votre mot de passe"),
                    prefixIcon: Icon(Icons.lock),
                    suffixIcon: InkWell(
                      onTap: () {
                        if (passToggle == true) {
                          passToggle = false;
                        } else {
                          passToggle = true;
                        }
                        setState(() {});
                      },
                      child: passToggle
                          ? Icon(CupertinoIcons.eye_slash_fill)
                          : Icon(CupertinoIcons.eye_fill),
                    ),
                  ),
                ),
              ),
              SizedBox(height: 20),
              
             Padding(
  padding: const EdgeInsets.all(15),
  child: Consumer<AuthModel>(
    builder: (context, auth, child) {
      return InkWell(
        onTap: () async {
              final result = await DioProvider().getToken(
              _emailController.text, _passwordController.text);
          if (result is bool && result) {
            auth.loginSuccess();
            MyApp.navigatorKey.currentState!.push(MaterialPageRoute(
              builder: (context) => NavBarRoots(),
            ));
          } else {
            Fluttertoast.showToast(
              msg: 'Informations d\'identification incorrectes',
              toastLength: Toast.LENGTH_SHORT,
              gravity: ToastGravity.BOTTOM,
              timeInSecForIosWeb: 1,
              backgroundColor: Colors.blue,
              textColor: Colors.white,
              fontSize: 18.0,
            );
          }
        },
        child: Container(
          padding: EdgeInsets.symmetric(vertical: 15),
          width: double.infinity,
          decoration: BoxDecoration(
            color: Color.fromARGB(248, 12, 155, 143),
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
              "S'identifier",
              style: TextStyle(
                fontSize: 23,
                fontWeight: FontWeight.bold,
                color: Colors.white,
              ),
            ),
          ),
        ),
      );
    },
  ),
),

            ],
          ),
        ),
      ),
    );
  }
}
