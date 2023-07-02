import 'package:flutter/material.dart';

class AuthModel extends ChangeNotifier {
  bool _isLogin = true;

  bool get isLogin => _isLogin;

  void loginSuccess() {
    _isLogin = true;
    notifyListeners();
  }

  void logout() {
    _isLogin = false;
    notifyListeners();
  }
}
