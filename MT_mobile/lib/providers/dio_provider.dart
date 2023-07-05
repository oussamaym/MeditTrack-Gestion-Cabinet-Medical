import 'dart:convert';
import 'package:shared_preferences/shared_preferences.dart';

import 'package:dio/dio.dart';
class DioProvider{
Future<dynamic> getToken(String email,String password) async {
try{
var response = await Dio().post('http://10.0.2.2:8000/api/login',
data:{'email':email,'password':password});
if(response.statusCode == 200 && response.data != ''){
final SharedPreferences prefs = await SharedPreferences.getInstance();
await prefs.setString('token',response.data);
return true;
}
else{
return false;
}
}
catch(error){
return error;
}
}
Future<dynamic> getUser(String token) async{
try{
var user=await Dio().get('http://10.0.2.2:8000/api/user',
options:Options(headers:{'Authorization':'Bearer $token'}));
if(user.statusCode == 200 && user.data != ''){
return json.encode(user.data);
}
}
catch(error)
{
return error;
}
}
//get doctors
Future<List<dynamic>> getDoctors(String token) async {
  try {
    var doctors = await Dio().get(
      'http://10.0.2.2:8000/api/medecins',
      options: Options(headers: {'Authorization': 'Bearer $token'}),
    );
    if (doctors.statusCode == 200 && doctors.data != '') {
      return doctors.data as List<dynamic>;
    }
  } catch (error) {
    throw error;
  }
  return []; // Return an empty list as a fallback
}
Future<dynamic> prendreRDV(String date,String day,String time,int medecin,int patient,String token) async{
 try{
  var response = await Dio().post('http://10.0.2.2:8000/api/ajouterRDV',data:{'date':date,'jour':day,'temps':time,'medecin_id':medecin,'patient_id':patient},
          options: Options(headers: {'Authorization': 'Bearer $token'}));

      if (response.statusCode == 200 && response.data != '') {
        return response.statusCode;
      } else {
        return 'Error';
      }
    } catch (error) {
      return error;
    }
  }

}