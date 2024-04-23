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
import java.util.List;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import java.util.ArrayList;
import android.widget.Toast;

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
    Button enrollButton, backButton;
    ListView courseListView;
    ArrayAdapter<String> adapter;
    List<String> courseInfoList;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_classregister);

        courseIdEditText = findViewById(R.id.courseIdEditText);
        sectionIdEditText = findViewById(R.id.sectionIdEditText);
        studentIdEditText = findViewById(R.id.studentIdEditText);
        enrollButton = findViewById(R.id.enrollButton);
        backButton = findViewById(R.id.backButton);
        courseListView = findViewById(R.id.courseListView);
        courseInfoTextView = findViewById(R.id.courseInfoTextView);
        courseInfoList = new ArrayList<>();
        adapter = new ArrayAdapter<>(this, android.R.layout.simple_list_item_1, courseInfoList);
        courseListView.setAdapter(adapter);

        enrollButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final String courseId = courseIdEditText.getText().toString();
                final String sectionId = sectionIdEditText.getText().toString();
                final String studentId = studentIdEditText.getText().toString();

                String url = getString(R.string.url) + "enroll.php";
                RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
                StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                        new Response.Listener<String>() {
                            @Override
                            public void onResponse(String response) {
                                // Handle successful enrollment (e.g., show a success message)
                                Toast.makeText(ClassRegister.this, "Enrollment successful", Toast.LENGTH_SHORT).show();
                            }
                        },
                        new Response.ErrorListener() {
                            @Override
                            public void onErrorResponse(VolleyError error) {
                                // Handle error response (e.g., show an error message)
                                Toast.makeText(ClassRegister.this, "Enrollment failed", Toast.LENGTH_SHORT).show();
                            }
                        }) {
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

    
        String url = getString(R.string.url) + "classRegister.php";
        RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
        StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject jsonResponse = new JSONObject(response);
                            JSONArray coursesArray = jsonResponse.getJSONArray("courses");
                            StringBuilder courseInfo = new StringBuilder();
                            for (int i = 0; i < coursesArray.length(); i++) {
                                JSONObject courseObject = coursesArray.getJSONObject(i);
                                String course = courseObject.getString("course");
                                double gradeAverage = courseObject.getDouble("grade_average");
                                String section = courseObject.getString("section");
                                String formattedCourseInfo = String.format("Course: %s\nGrade Average: %.2f\nSection: %s\n\n", course, gradeAverage, section);
                                courseInfo.append(formattedCourseInfo);
                            }
                            courseInfoTextView.setText(courseInfo.toString());
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        // Handle error
                    }
                }) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<>();
                params.put("courseId", courseIdEditText.getText().toString());
                params.put("sectionId", sectionIdEditText.getText().toString());
                params.put("studentId", studentIdEditText.getText().toString());
                return params;
            }
        };
        queue.add(stringRequest);
    }

}
