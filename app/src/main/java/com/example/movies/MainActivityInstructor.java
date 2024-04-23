package com.example.movies;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

public class MainActivityInstructor extends AppCompatActivity {

    TextView textViewName, textViewEmail, textViewCourseRecord;
    SharedPreferences sharedPreferences;
    Button buttonLogout;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        //sharedPreferences = getSharedPreferences("Phase3", MODE_PRIVATE);
        setContentView(R.layout.activity_main_instructor);
        textViewName = findViewById(R.id.name);
        textViewEmail = findViewById(R.id.email);
        buttonLogout = findViewById(R.id.logout);
        //registerButton = findViewById(R.id.registerButton);
        textViewCourseRecord = findViewById(R.id.courseRecord);
        sharedPreferences = getSharedPreferences("Phase3", MODE_PRIVATE);
        if (sharedPreferences.getString("logged", "false").equals("false")){
            Intent intent = new Intent(getApplicationContext(), Login.class);
            startActivity(intent);
            finish();
        }
        textViewName.setText(sharedPreferences.getString("name",""));
        textViewEmail.setText(sharedPreferences.getString("email",""));


        buttonLogout.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                SharedPreferences.Editor editor = sharedPreferences.edit();
                editor.putString("logged", "false");
                editor.putString("name", "");
                editor.putString("email", "");
                editor.apply();
                Intent intent = new Intent(getApplicationContext(), Login.class);
                startActivity(intent);
                finish();
            }
        });
        /*registerButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(getApplicationContext(), ClassRegister.class);
                startActivity(intent);
                finish();
            }
        });*/


        textViewCourseRecord.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(getApplicationContext(), EnterInstructorID.class);
                startActivity(intent);
                finish();
            }
        });
    }
}
