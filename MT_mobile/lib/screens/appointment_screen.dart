import 'package:flutter/material.dart';
import 'package:flutter_picker/flutter_picker.dart';

class AppointmentScreen extends StatefulWidget {
  @override
  _AppointmentScreenState createState() => _AppointmentScreenState();
}

class _AppointmentScreenState extends State<AppointmentScreen> {
  DateTime selectedDateTime=DateTime.now();

  void _showDateTimePicker() {
    Picker(
      adapter: DateTimePickerAdapter(
        type: PickerDateTimeType.kYMDHM,
        isNumberMonth: true,
        value: selectedDateTime,
        minValue: DateTime.now(),
        maxValue: DateTime.now().add(Duration(days: 365)),
      ),
      title: Text("Select Date and Time"),
      onConfirm: (Picker picker, List<int> value) {
        setState(() {

           final selectedValue = picker.adapter.text;
          selectedDateTime = DateTime.parse(selectedValue);
        });
      },
    ).showDialog(context);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Appointment'),
      ),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            ElevatedButton(
              onPressed: _showDateTimePicker,
              child: Text('Select Date and Time'),
            ),
            SizedBox(height: 16),
            Text(
              selectedDateTime != null
                  ? 'Selected Date and Time: $selectedDateTime'
                  : 'No date and time selected.',
              style: TextStyle(fontSize: 16),
            ),
          ],
        ),
      ),
    );
  }
}
