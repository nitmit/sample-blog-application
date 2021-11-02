import 'package:flutter/material.dart';
import 'package:flutterboilerplatesample/ui/home_page.dart';
import 'package:flutterboilerplatesample/ui/login_page.dart';
import 'package:flutterboilerplatesample/ui/register_page.dart';

class RouteGenerator {
  static Route<dynamic> generateRoute(RouteSettings routeSettings) {
    final args = routeSettings.arguments;
    switch (routeSettings.name) {
      case "/register":
        return MaterialPageRoute(builder: (context) => RegisterPage());
      case "/login":
        return MaterialPageRoute(builder: (context) => LoginPage());
      case "/home":
        return MaterialPageRoute(builder: (context) => MyHomePage(title: "Home"));
    }
  }
}
