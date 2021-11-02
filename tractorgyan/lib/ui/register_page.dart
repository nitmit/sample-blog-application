import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutterboilerplatesample/base/base_view.dart';
import 'package:flutterboilerplatesample/base/injection.dart';
import 'package:flutterboilerplatesample/view_models/register_view_model.dart';
import 'package:hexcolor/hexcolor.dart';
import 'package:flutter_typeahead/flutter_typeahead.dart';
import 'footer.dart';

class RegisterPage extends StatelessWidget {
  const RegisterPage({Key key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    bool rememberMe = false;
    TextEditingController nameController = TextEditingController();
    TextEditingController mobileController = TextEditingController();
    TextEditingController passwordController = TextEditingController();
    TextEditingController stateController = TextEditingController();
    TextEditingController districtController = TextEditingController();
    TextEditingController tahsilController = TextEditingController();
    final _formKey = GlobalKey<FormState>();

    return Scaffold(
      body: BaseView<RegisterViewModel>(onModelReady: (registerViewModel) {
        Injection.resetTokenAndInterceptor();
      }, builder: (context, registerViewModel, child) {
        child:
        return SingleChildScrollView(
          child: Column(
            children: [
              Padding(
                padding: EdgeInsetsDirectional.fromSTEB(20, 10, 20, 10),
                child: Card(
                  clipBehavior: Clip.antiAliasWithSaveLayer,
                  color: Colors.white,
                  elevation: 4,
                  child: Form(
                    key: _formKey,
                    child: Column(
                      mainAxisSize: MainAxisSize.max,
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Padding(
                          padding: EdgeInsetsDirectional.fromSTEB(20, 20, 0, 0),
                          child: Text(
                            'REGISTER',
                            style: TextStyle(
                              fontSize: 24,
                              fontWeight: FontWeight.w800,
                            ),
                          ),
                        ),
                        Padding(
                          padding: EdgeInsetsDirectional.fromSTEB(20, 5, 0, 0),
                          child: Text(
                            "Register now. It's free!",
                            style: TextStyle(
                              fontSize: 14,
                              fontWeight: FontWeight.normal,
                            ),
                          ),
                        ),
                        Padding(
                          padding: EdgeInsetsDirectional.fromSTEB(20, 20, 20, 0),
                          child: TextFormField(
                            validator: (value) {
                              if (value.isEmpty)
                                return "Name can not be empty";
                              return null;
                            },
                            controller: nameController,
                            obscureText: false,
                            decoration: InputDecoration(
                              labelText: 'Name',
                              labelStyle: TextStyle(
                                color: Color(0xFFAAAAAA),
                                fontSize: 16,
                              ),
                              hintText: '(required)',
                              hintStyle: TextStyle(
                                color: Color(0xFFAAAAAA),
                                fontSize: 16,
                              ),
                              enabledBorder: UnderlineInputBorder(
                                borderSide: BorderSide(
                                  color: Color(0xFFAAAAAA),
                                  width: 1,
                                ),
                                borderRadius: const BorderRadius.only(
                                  topLeft: Radius.circular(4.0),
                                  topRight: Radius.circular(4.0),
                                ),
                              ),
                              focusedBorder: UnderlineInputBorder(
                                borderSide: BorderSide(
                                  color: Color(0xFFAAAAAA),
                                  width: 1,
                                ),
                                borderRadius: const BorderRadius.only(
                                  topLeft: Radius.circular(4.0),
                                  topRight: Radius.circular(4.0),
                                ),
                              ),
                              prefixIcon: Icon(
                                Icons.person_rounded,
                                color: Color(0xFF060606),
                              ),
                            ),
                            style: TextStyle(
                              color: Color(0xFFAAAAAA),
                              fontSize: 16,
                            ),
                          ),
                        ),
                        Padding(
                          padding: EdgeInsetsDirectional.fromSTEB(20, 20, 20, 0),
                          child: TextFormField(
                            validator: (value) {
                              if (value.isEmpty)
                                return "Mobile can not be empty";
                              return null;
                            },
                            controller: mobileController,
                            obscureText: false,
                            decoration: InputDecoration(
                              labelText: 'Mobile',
                              labelStyle: TextStyle(
                                color: Color(0xFFAAAAAA),
                                fontSize: 16,
                              ),
                              hintText: '(required)',
                              hintStyle: TextStyle(
                                color: Color(0xFFAAAAAA),
                                fontSize: 16,
                              ),
                              enabledBorder: UnderlineInputBorder(
                                borderSide: BorderSide(
                                  color: Color(0xFFAAAAAA),
                                  width: 1,
                                ),
                                borderRadius: const BorderRadius.only(
                                  topLeft: Radius.circular(4.0),
                                  topRight: Radius.circular(4.0),
                                ),
                              ),
                              focusedBorder: UnderlineInputBorder(
                                borderSide: BorderSide(
                                  color: Color(0xFFAAAAAA),
                                  width: 1,
                                ),
                                borderRadius: const BorderRadius.only(
                                  topLeft: Radius.circular(4.0),
                                  topRight: Radius.circular(4.0),
                                ),
                              ),
                              prefixIcon: Icon(
                                Icons.alternate_email,
                                color: Color(0xFF060606),
                              ),
                            ),
                            style: TextStyle(
                              color: Color(0xFFAAAAAA),
                              fontSize: 16,
                            ),
                          ),
                        ),
                        Padding(
                          padding: EdgeInsetsDirectional.fromSTEB(20, 10, 20, 10),
                          child: TextFormField(
                            validator: (value) {
                              if (value.isEmpty)
                                return "Password can not be empty";
                              return null;
                            },
                            controller: passwordController,
                            obscureText: false,
                            decoration: InputDecoration(
                              labelText: 'Password',
                              labelStyle: TextStyle(
                                color: Color(0xFFAAAAAA),
                                fontSize: 16,
                              ),
                              hintText: '(required)',
                              hintStyle: TextStyle(
                                color: Color(0xFFAAAAAA),
                                fontSize: 16,
                              ),
                              enabledBorder: UnderlineInputBorder(
                                borderSide: BorderSide(
                                  color: Color(0xFFAAAAAA),
                                  width: 1,
                                ),
                                borderRadius: const BorderRadius.only(
                                  topLeft: Radius.circular(4.0),
                                  topRight: Radius.circular(4.0),
                                ),
                              ),
                              focusedBorder: UnderlineInputBorder(
                                borderSide: BorderSide(
                                  color: Color(0xFFAAAAAA),
                                  width: 1,
                                ),
                                borderRadius: const BorderRadius.only(
                                  topLeft: Radius.circular(4.0),
                                  topRight: Radius.circular(4.0),
                                ),
                              ),
                              prefixIcon: Icon(
                                Icons.lock_rounded,
                                color: Color(0xFF060606),
                              ),
                            ),
                            style: TextStyle(
                              color: Color(0xFFAAAAAA),
                              fontSize: 16,
                            ),
                          ),
                        ),
                        Container(
                          margin: const EdgeInsets.symmetric(
                              horizontal: 20, vertical: 10),
                          child: TypeAheadFormField(
                            textFieldConfiguration: TextFieldConfiguration(
                                controller: stateController,
                              decoration: InputDecoration(
                                labelText: 'State',
                                labelStyle: TextStyle(
                                  color: Color(0xFFAAAAAA),
                                  fontSize: 16,
                                ),
                                enabledBorder: UnderlineInputBorder(
                                  borderSide: BorderSide(
                                    color: Color(0xFFAAAAAA),
                                    width: 1,
                                  ),
                                  borderRadius: const BorderRadius.only(
                                    topLeft: Radius.circular(4.0),
                                    topRight: Radius.circular(4.0),
                                  ),
                                ),
                                focusedBorder: UnderlineInputBorder(
                                  borderSide: BorderSide(
                                    color: Color(0xFFAAAAAA),
                                    width: 1,
                                  ),
                                  borderRadius: const BorderRadius.only(
                                    topLeft: Radius.circular(4.0),
                                    topRight: Radius.circular(4.0),
                                  ),
                                ),
                                prefixIcon: Icon(
                                  Icons.location_city_rounded,
                                  color: Color(0xFF060606),
                                ),
                              ),
                              style: TextStyle(
                                color: Color(0xFFAAAAAA),
                                fontSize: 16,
                              ),
                            ),
                            suggestionsCallback: (pattern) {
                              //if (pattern.length < 2) return [];
                              return registerViewModel.states.where((item) => item.toLowerCase().startsWith(pattern.toLowerCase())).toList();
                            },
                            itemBuilder: (context, suggestion) {
                              return ListTile(
                                title: Text(suggestion),
                              );
                            },
                            transitionBuilder: (context, suggestionsBox, controller) {
                              return suggestionsBox;
                            },
                            onSuggestionSelected: (suggestion) {
                              stateController.text = suggestion;
                              registerViewModel.setState(suggestion);
                              print(suggestion);
                              registerViewModel.getDistricts(suggestion);
                            },
                            validator: (value) {
                              if (value.isEmpty) {
                                return 'Please select a state';
                              }
                            },
                            //onSaved: (value) => this._selectedCity = value,
                          ),
                        ),
                        Container(
                          margin: const EdgeInsets.symmetric(
                              horizontal: 20, vertical: 10),
                          // child: TypeAheadField(
                          //   textFieldConfiguration: TextFieldConfiguration(
                          //     autocorrect: false,
                          //     autofocus: false,
                          //     decoration: InputDecoration(
                          //       labelText: 'Select District',
                          //       labelStyle: TextStyle(
                          //         color: Color(0xFFAAAAAA),
                          //         fontSize: 16,
                          //       ),
                          //       hintText: '(required)',
                          //       hintStyle: TextStyle(
                          //         color: Color(0xFFAAAAAA),
                          //         fontSize: 16,
                          //       ),
                          //       enabledBorder: UnderlineInputBorder(
                          //         borderSide: BorderSide(
                          //           color: Color(0xFFAAAAAA),
                          //           width: 1,
                          //         ),
                          //         borderRadius: const BorderRadius.only(
                          //           topLeft: Radius.circular(4.0),
                          //           topRight: Radius.circular(4.0),
                          //         ),
                          //       ),
                          //       focusedBorder: UnderlineInputBorder(
                          //         borderSide: BorderSide(
                          //           color: Color(0xFFAAAAAA),
                          //           width: 1,
                          //         ),
                          //         borderRadius: const BorderRadius.only(
                          //           topLeft: Radius.circular(4.0),
                          //           topRight: Radius.circular(4.0),
                          //         ),
                          //       ),
                          //       prefixIcon: Icon(
                          //         Icons.location_city_rounded,
                          //         color: Colors.black,
                          //       ),
                          //     ),
                          //     style: TextStyle(
                          //       color: Color(0xFFAAAAAA),
                          //       fontSize: 16,
                          //     ),
                          //   ),
                          //   suggestionsCallback: (pattern) async {
                          //     if (pattern.length < 2) return [];
                          //     return registerViewModel.districts.where((item) => item.toLowerCase().startsWith(pattern.toLowerCase())).toList();
                          //   },
                          //   suggestionsBoxDecoration: SuggestionsBoxDecoration(
                          //     borderRadius: BorderRadius.circular(10),
                          //   ),
                          //   itemBuilder: (context, suggestion) {
                          //     return Container(
                          //       margin: const EdgeInsets.only(
                          //           left: 10, right: 10, bottom: 5, top: 5),
                          //       child: Text(suggestion,
                          //           style: TextStyle(
                          //             color: Colors.black,
                          //           )),
                          //     );
                          //   },
                          //   onSuggestionSelected: (suggestion) {
                          //     registerViewModel.setDistrict(suggestion);
                          //     print(suggestion);
                          //     registerViewModel.getTahsils(suggestion);
                          //   },
                          //   noItemsFoundBuilder: (context) {
                          //     return Container(
                          //       margin: const EdgeInsets.only(
                          //           left: 10, right: 10, bottom: 5, top: 5),
                          //       child: Text("No results found",
                          //           style: TextStyle(
                          //             color: Colors.black,
                          //           )),
                          //     );
                          //   },
                          // ),
                          child: TypeAheadFormField(
                            textFieldConfiguration: TextFieldConfiguration(
                              controller: districtController,
                              decoration: InputDecoration(
                                labelText: 'District',
                                labelStyle: TextStyle(
                                  color: Color(0xFFAAAAAA),
                                  fontSize: 16,
                                ),
                                hintText: '(required)',
                                hintStyle: TextStyle(
                                  color: Color(0xFFAAAAAA),
                                  fontSize: 16,
                                ),
                                enabledBorder: UnderlineInputBorder(
                                  borderSide: BorderSide(
                                    color: Color(0xFFAAAAAA),
                                    width: 1,
                                  ),
                                  borderRadius: const BorderRadius.only(
                                    topLeft: Radius.circular(4.0),
                                    topRight: Radius.circular(4.0),
                                  ),
                                ),
                                focusedBorder: UnderlineInputBorder(
                                  borderSide: BorderSide(
                                    color: Color(0xFFAAAAAA),
                                    width: 1,
                                  ),
                                  borderRadius: const BorderRadius.only(
                                    topLeft: Radius.circular(4.0),
                                    topRight: Radius.circular(4.0),
                                  ),
                                ),
                                prefixIcon: Icon(
                                  Icons.location_city_rounded,
                                  color: Color(0xFF060606),
                                ),
                              ),
                              style: TextStyle(
                                color: Color(0xFFAAAAAA),
                                fontSize: 16,
                              ),
                            ),
                            suggestionsCallback: (pattern) {
                              //if (pattern.length < 2) return [];
                              return registerViewModel.districts.where((item) => item.toLowerCase().startsWith(pattern.toLowerCase())).toList();
                            },
                            itemBuilder: (context, suggestion) {
                              return ListTile(
                                title: Text(suggestion),
                              );
                            },
                            transitionBuilder: (context, suggestionsBox, controller) {
                              return suggestionsBox;
                            },
                            onSuggestionSelected: (suggestion) {
                              districtController.text = suggestion;
                              registerViewModel.setDistrict(suggestion);
                              print(suggestion);
                              registerViewModel.getTahsils(suggestion);
                            },
                            validator: (value) {
                              if (value.isEmpty) {
                                return 'Please select a district';
                              }
                            },
                            //onSaved: (value) => this._selectedCity = value,
                          ),

                        ),
                        Container(
                          margin: const EdgeInsets.symmetric(
                              horizontal: 20, vertical: 10),
                          child: DropdownButtonFormField(
                            items: registerViewModel.tahsils
                                .map((e) =>
                                    DropdownMenuItem(child: Text(e), value: e))
                                .toList(),
                            onChanged: (a) {
                              registerViewModel.setTahsil(a);
                            },
                            value: registerViewModel.selectedTahsil,
                            validator: (value) {
                              if (value == null) return "Select a tehsil";
                              return null;
                            },
                            decoration: InputDecoration(
                              labelText: 'Tehsil',
                              labelStyle: TextStyle(
                                color: Color(0xFFAAAAAA),
                                fontSize: 16,
                              ),
                              hintText: '(required)',
                              hintStyle: TextStyle(
                                color: Color(0xFFAAAAAA),
                                fontSize: 16,
                              ),
                              enabledBorder: UnderlineInputBorder(
                                borderSide: BorderSide(
                                  color: Color(0xFFAAAAAA),
                                  width: 1,
                                ),
                                borderRadius: const BorderRadius.only(
                                  topLeft: Radius.circular(4.0),
                                  topRight: Radius.circular(4.0),
                                ),
                              ),
                              focusedBorder: UnderlineInputBorder(
                                borderSide: BorderSide(
                                  color: Color(0xFFAAAAAA),
                                  width: 1,
                                ),
                                borderRadius: const BorderRadius.only(
                                  topLeft: Radius.circular(4.0),
                                  topRight: Radius.circular(4.0),
                                ),
                              ),
                              prefixIcon: Icon(
                                Icons.location_city_rounded,
                                color: Colors.black,
                              ),
                            ),
                            style: TextStyle(
                              color: Color(0xFFAAAAAA),
                              fontSize: 16,
                            ),
                          ),
                        ),
                        Padding(
                          padding: EdgeInsetsDirectional.fromSTEB(20, 20, 20, 10),
                          child: Row(
                            mainAxisSize: MainAxisSize.max,
                            mainAxisAlignment: MainAxisAlignment.center,
                            children: [
                              Text(
                                'Already registered? Sign In here',
                                textAlign: TextAlign.start,
                                style: TextStyle(
                                  color: Color(0xFFAAAAAA),
                                  fontSize: 16,
                                  fontWeight: FontWeight.normal,
                                ),
                              ),
                            ],
                          ),
                        ),
                        Padding(
                          padding: EdgeInsetsDirectional.fromSTEB(20, 10, 20, 10),
                          child: Row(
                            children: [
                              Expanded(
                                child: ElevatedButton(
                                  onPressed: () async {
                                    if (!_formKey.currentState.validate()) {
                                      return;
                                    }
                                    bool valid = await registerViewModel.register(
                                        nameController.text,
                                        mobileController.text,
                                        passwordController.text);
                                    if(valid) {
                                      Navigator.pushNamedAndRemoveUntil(
                                          context, "/home", (route) => false);
                                    }
                                  },
                                  child: const Text('REGISTER ACCOUNT'),
                                  style: ElevatedButton.styleFrom(
                                    primary: HexColor("#a0d468"),
                                    textStyle: TextStyle(
                                      color: Colors.white,
                                      fontSize: 18,
                                      fontWeight: FontWeight.w700,
                                    ),
                                  ),
                                ),
                              )
                            ],
                          ),
                        ),
                      ],
                    ),
                  ),
                ),
              ),
              //Footer
              Footer(topTractors: Injection.footerTopTractors)
            ],
          ),
        );
      }),
    );
  }
}
