import 'dart:convert';

import 'package:flutterboilerplatesample/models/login_response.dart';
import 'package:shared_preferences/shared_preferences.dart';

class SharedPrefs {
  SharedPreferences _prefs;
  static const key_token = "token";
  static const key_user = "user";
  static const key_user_id = "user_id";


  User _user;


  SharedPreferences get prefs => _prefs;

  init() async {
    _prefs = await SharedPreferences.getInstance();
  }

  //----------------METHODS FOR CUSTOMER---------------------//
  Future<void> saveToken(String token) async {
    await _prefs.setString(key_token, token);
   // await _prefs.setInt(key_user_id, userId);
  }

  Future<void> saveUser(String user) async {
    await _prefs.setString(key_user, user);
    _user = null;
    getUser();
  }


  String getToken() {
    return _prefs.getString(key_token);
  }


  // int getUserId() {
  //   return _prefs.getInt(key_user_id);
  // }
  //
  User getUser() {
    final String userString = _prefs.getString(key_user);
    if (userString == null) return null;
    if (_user == null) _user = User.fromJson(jsonDecode(userString));
    return _user;
  }


  Future<void> removeUser() async {
    await _prefs.remove(key_user_id);
    await _prefs.remove(key_user);
    await _prefs.remove(key_token);
  }

}
