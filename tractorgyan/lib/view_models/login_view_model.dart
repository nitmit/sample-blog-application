import 'dart:convert';

import 'package:bot_toast/bot_toast.dart';
import 'package:dio/dio.dart';
import 'package:flutterboilerplatesample/base/base_view_model.dart';
import 'package:flutterboilerplatesample/base/injection.dart';
import 'package:flutterboilerplatesample/base/shared_preferences.dart';
import 'package:flutterboilerplatesample/models/login_response.dart';
import 'package:flutterboilerplatesample/services/user_service.dart';

class LoginViewModel extends BaseViewModel {
  final sharedPrefs = Injection.injector.get<SharedPrefs>();
  final UserService _userService = Injection.injector.get();

  Future<bool> login(String email, String password) async {
    Injection.resetTokenAndInterceptor();
    try {
      BotToast.showLoading();
      final Response response = await _userService.login(email, password);
      final loginResponse = LoginResponse.fromJson(response.data);

      await sharedPrefs.saveToken(loginResponse.jwt);
      Injection.refreshToken();
      Injection.setupDioInterceptor();

      //get the logged in user
      final Response response1 = await _userService.fetchUser(sharedPrefs.getToken());
      final user = User.fromJson(response1.data['user']);
      await sharedPrefs.saveUser(jsonEncode(user.toJson()));

    } catch (exception) {
      print(exception.toString());
      if (exception is DioError && exception.response != null && exception.response.statusCode == 400) {
        BotToast.showSimpleNotification(title: "Invalid email/password", duration: Duration(seconds: 3));
      } else {
        BotToast.showSimpleNotification(
            title: "Something went wrong. Please try again later.", duration: Duration(seconds: 3));
      }
      return false;
    } finally {
      BotToast.closeAllLoading();
    }
    return true;
  }

}