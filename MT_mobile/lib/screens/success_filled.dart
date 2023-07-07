import 'package:healthcare/components/button.dart';
import 'package:flutter/material.dart';
import 'package:healthcare/main.dart';
import 'package:healthcare/widgets/navbar_roots.dart';
import 'package:lottie/lottie.dart';

class SucessFilledScreen extends StatelessWidget {
  const SucessFilledScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SafeArea(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: <Widget>[
            Expanded(
              flex: 3,
              child: Lottie.asset('images/success.json'),
            ),
            Container(
              width: double.infinity,
              alignment: Alignment.center,
              child: const Text(
                'Dossier médical rempli avec succès',
                style: TextStyle(
                  fontSize: 20,
                  fontWeight: FontWeight.bold,
                ),
              ),
            ),
            const Spacer(),
            //back to home page
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 15),
              child: Button(
                width: double.infinity,
                title: 'Retourner à la page d\'accueil',
                onPressed: () => MyApp.navigatorKey.currentState!.push(MaterialPageRoute(
              builder: (context) => NavBarRoots(),
            )),
                disable: false,
              ),
            )
          ],
        ),
      ),
    );
  }
}
