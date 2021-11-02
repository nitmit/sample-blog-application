
class LoginResponse {
  String jwt;

  LoginResponse({this.jwt});

  LoginResponse.fromJson(Map<String, dynamic> json) {
    jwt = json['access_token'];
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['access_token'] = this.jwt;
    return data;
  }
}

class User {
  int id;
  String name;
  String email;
  String createdAt;
  String updatedAt;
  int roleId;
  String resetUrl;
  String deletedAt;
  String teamId;
  int approved;
  String brand;
  String location;

  User({
    this.id,
    this.name,
    this.email,
    this.createdAt,
    this.updatedAt,
    this.deletedAt,
    this.resetUrl,
    this.roleId,
    this.teamId,
    this.brand,
    this.approved,
    this.location
  });

  User.fromJson(Map<String, dynamic> json) {
    id = json['id'];
    name = json['name'];
    email = json['email'];
    roleId = json['role_id'];
    createdAt = json['created_at'];
    updatedAt = json['updated_at'];
    deletedAt = json['deleted_at'];
    location = json['location'];
    brand = json['brand'];
    teamId = json['team_id'];
    resetUrl = json['reset_url'];
    approved = json['approved'];
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['id'] = this.id;
    data['name'] = this.name;
    data['email'] = this.email;
    data['role_id'] = this.roleId;
    data['reset_url'] = this.resetUrl;
    data['team_id'] = this.teamId;
    data['created_at'] = this.createdAt;
    data['updated_at'] = this.updatedAt;
    data['deleted_at'] = this.deletedAt;
    data['location'] = this.location;
    data['brand'] = this.brand;
    data['approved'] = this.approved;
    return data;
  }

  //
  // Map<String, dynamic> getProfileFields() {
  //   return {
  //     "name": this.name,
  //     "email": this.email,
  //     "mobile": this.mobile,
  //     "whatsapp_mobile": this.whatsappMobile,
  //     "address": this.address,
  //     "contact_person": this.contactPerson
  //   };
  // }
}

