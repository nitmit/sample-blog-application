import 'package:dio/dio.dart';
import 'package:flutterboilerplatesample/base/injection.dart';

class UserService {
  final Dio dio = Injection.injector.get();

  Future<Response> login(String email, String password) {
    return dio.post("/auth/login", data: {"email": email, "password": password});
  }

  Future<Response> fetchUser(String token){
    return dio.post('/auth/get_user', data: {"token": token});
  }

  Future<Response> register(
      String name, String mobile, String password, String state, String district, String tahsil) {
    return dio.post("/auth/register", data: {
      "mobile": mobile,
      "name": name,
      "password": password,
      "state": "state",
      "district": district,
      "tahsil": tahsil,
    });
  }

  Future<Response> getDistricts(String state) async {
    return dio.get('https://tractorgyan.com/getdistrict/'+state);
  }

  Future<Response> getTahsils(String district) async {
    return dio.get('https://tractorgyan.com/gettahsil/'+district);
  }
}
