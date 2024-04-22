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

public class EnterID extends AppCompatActivity {

    EditText etID;
    String enteredID, id, curCourses, pastCourses, name;
    Button buttonSubmit;
    SharedPreferences sharedPreferences;



    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_enterid);
        etID = findViewById(R.id.id);
        buttonSubmit = findViewById(R.id.viewCourseRecord);
        sharedPreferences = getSharedPreferences("Phase3", MODE_PRIVATE);

        buttonSubmit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                enteredID = etID.getText().toString();

                RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
                String url = getString(R.string.url) + "courseRecord.php";

                StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                        new Response.Listener<String>() {
                            @Override
                            public void onResponse(String response) {
                                try {
                                    JSONObject jsonObject = new JSONObject(response);
                                    String status = jsonObject.getString("status");
                                    name = jsonObject.getString("name");
                                    if (status.equals("true") && sharedPreferences.getString("name","null").equals(name)){
                                        curCourses = jsonObject.getString("cur-courses");
                                        pastCourses = jsonObject.getString("past-courses");
                                        id = jsonObject.getString("id");
                                        SharedPreferences.Editor editor = sharedPreferences.edit();
                                        editor.putString("logged", "true");
                                        editor.putString("curCourses", curCourses.toString());
                                        editor.putString("pastCourses", pastCourses.toString());
                                        editor.putString("id", id);
                                        editor.apply();
                                        Intent intent = new Intent(getApplicationContext(), CourseRecord.class);
                                        startActivity(intent);
                                        finish();
                                    }
                                } catch (JSONException e) {
                                    e.printStackTrace();
                                }
                            }
                        }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        error.printStackTrace();
                    }
                }){

                    protected Map<String, String> getParams(){
                        Map<String, String> paramV = new HashMap<>();
                        paramV.put("id", enteredID);
                        return paramV;
                    }
                };
                queue.add(stringRequest);
            }
        });
    }
}