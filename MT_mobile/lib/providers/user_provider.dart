import 'package:flutter/material.dart';

class UserProvider extends ChangeNotifier {
  Map<String, dynamic> user = {};

  void updateUser(Map<String, dynamic> newUser) {
    user = newUser;
    notifyListeners();
  }
}