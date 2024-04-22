package com.example.movies;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.VolleyLog;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class ClassRegister extends AppCompatActivity {
    EditText courseIdEditText, sectionIdEditText, studentIdEditText;
    TextView courseInfoTextView;
    String courseName, sectionName;
    double gradeAverage;
    Button enrollButton, backButton;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_classregister);

        courseIdEditText = findViewById(R.id.courseIdEditText);
        sectionIdEditText = findViewById(R.id.sectionIdEditText);
        studentIdEditText = findViewById(R.id.studentIdEditText);
        //courseInfoTextView = findViewById(R.id.courseInfoTextView);
        enrollButton = findViewById(R.id.enrollButton);
        backButton = findViewById(R.id.backButton);

        enrollButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String courseId = courseIdEditText.getText().toString();
                String sectionId = sectionIdEditText.getText().toString();
                String studentId = studentIdEditText.getText().toString();

                String url = getString(R.string.url) + "classRegister.php";

                RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
                StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                        new Response.Listener<String>() {
                            @Override
                            public void onResponse(String response) {
                                try {
                                    JSONObject jsonResponse = new JSONObject(response);
                                    String status = jsonResponse.getString("status");
                                    if (status.equals("true")) {
                                        courseName = jsonResponse.getString("courseId");
                                        sectionName = jsonResponse.getString("sectionId");
                                        gradeAverage = jsonResponse.getDouble("gradeAverage");

                                        //Display the information in courseInfoTextView
                                        String info = "Course: " + courseName + "\nSection: " + sectionName + "\nGrade Average: " + gradeAverage;
                                        courseInfoTextView.setText(info);
                                    }
                                } catch (JSONException e) {
                                    e.printStackTrace();
                                }
                            }
                        },
                        null
                ) {
                    @Override
                    protected Map<String, String> getParams() {
                        Map<String, String> params = new HashMap<>();
                        params.put("courseId", courseId);
                        params.put("sectionId", sectionId);
                        params.put("studentId", studentId);
                        return params;
                    }
                };
                queue.add(stringRequest);

            }
        });

        backButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(getApplicationContext(), MainActivity.class);
                startActivity(intent);
                finish();
            }
        });
    }
}
