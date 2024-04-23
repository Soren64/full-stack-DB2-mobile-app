package com.example.movies;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

public class InstructorRecord extends AppCompatActivity {

    TextView textViewCurCourses, textViewPastCourses, textViewReturnMain;
    SharedPreferences sharedPreferences;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_instructorrecord);
        textViewCurCourses = findViewById(R.id.currentCourses);
        textViewPastCourses = findViewById(R.id.pastCourses);
        textViewReturnMain = findViewById(R.id.returnMain);

        sharedPreferences = getSharedPreferences("Phase3", MODE_PRIVATE);
        textViewCurCourses.setText(sharedPreferences.getString("curCourses",""));
        textViewPastCourses.setText(sharedPreferences.getString("pastCourses",""));


        textViewReturnMain.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(getApplicationContext(), MainActivityInstructor.class);
                startActivity(intent);
                finish();
            }
        });
    }
}