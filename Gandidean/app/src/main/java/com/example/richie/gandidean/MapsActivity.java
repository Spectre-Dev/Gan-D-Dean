/*Author: Richie Mangan
 *Student No: X13114514
 *Class: BSCH3B
 */

package com.example.richie.gandidean;

import android.app.ActionBar;
import android.app.Dialog;
import android.app.Fragment;
import android.app.FragmentManager;
import android.content.Intent;
import android.graphics.drawable.ColorDrawable;
import android.location.Location;
import android.net.Uri;
import android.os.Bundle;
import android.support.v4.app.FragmentActivity;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.RelativeLayout;
import android.widget.Toast;
import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.GooglePlayServicesUtil;
import com.google.android.gms.common.api.GoogleApiClient;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.maps.CameraUpdate;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.LatLng;

import java.util.ArrayList;


public class MapsActivity extends FragmentActivity implements OnMapReadyCallback,
        GoogleApiClient.ConnectionCallbacks, GoogleApiClient.OnConnectionFailedListener {

    private GoogleMap mMap;
    private static final int GPS_ERRORDIALOG_REQUEST = 9001;
    private static String TAG = MapsActivity.class.getSimpleName();
    private GoogleApiClient mGoogleApiClient;
    private DrawerLayout mDrawerLayout;
    ActionBarDrawerToggle mDrawerToggle;
    private Location mLastLocation;
    RelativeLayout mDrawerPane;
    ListView mDrawerList;
    double lat = 53.3487808;
    double lng = -6.2427731;
    Double latitude = 0.0;
    Double longitude = 0.0;
    int DEFAULTZOOM = 17; //default zoom level for maps
    float zoom;

    ArrayList<NavItem> mNavItems = new ArrayList<NavItem>(); //arraylist for items in the pull out nav drawer

    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        if (servicesOK()) {
            setContentView(R.layout.activity_maps);   //this was the original basic map, without fancy layout
            getActionBar().setDisplayHomeAsUpEnabled(true); //setting the action bar to display
            ActionBar bar = getActionBar(); //getting the action bar to change the colour of it below
            bar.setBackgroundDrawable(new ColorDrawable(0xFFFF6666)); //changing the colour

            buildGoogleApiClient();//declaring the Google API class for getLastLocation

            //these are the pull out menu options
            mNavItems.add(new NavItem("New Sighting", "Pin a new sighting location", R.drawable.new_pin));
            mNavItems.add(new NavItem("Active People", "See nearby homeless", R.drawable.active_pins));
            mNavItems.add(new NavItem("Homeless Services", "View list of local services", R.drawable.homeless_serv));

            // DrawerLayout
            mDrawerLayout = (DrawerLayout) findViewById(R.id.drawerLayout);

            // Populate the Navigtion Drawer with options
            mDrawerPane = (RelativeLayout) findViewById(R.id.drawerPane);
            mDrawerList = (ListView) findViewById(R.id.navList);
            DrawerListAdapter adapter = new DrawerListAdapter(this, mNavItems);
            mDrawerList.setAdapter(adapter);

            // Drawer Item click listeners
            mDrawerList.setOnItemClickListener(new AdapterView.OnItemClickListener() {
                @Override
                public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                    selectItemFromDrawer(position);
                }
            });

            //this code handles the toggling of the action bar slide out menu
            mDrawerToggle = new ActionBarDrawerToggle(this, mDrawerLayout, R.string.drawer_open, R.string.drawer_close) {
                @Override
                public void onDrawerOpened(View drawerView) {
                    super.onDrawerOpened(drawerView);
                    Log.d(TAG, "onDrawerOpened: " + getTitle());  //writing to the logkat when the drawer is opened
                    invalidateOptionsMenu();
                }

                @Override
                public void onDrawerClosed(View drawerView) {
                    super.onDrawerClosed(drawerView);
                    Log.d(TAG, "onDrawerClosed: " + getTitle()); //writing to the logkat when the drawer is closed

                    invalidateOptionsMenu();
                }
            };

            mDrawerLayout.setDrawerListener(mDrawerToggle);


            if (initMap()) {
                Toast.makeText(this, "Ready to map", Toast.LENGTH_SHORT).show();
            } else {
                Toast.makeText(this, "Map not available", Toast.LENGTH_SHORT).show();
            }
        }

        // Obtain the SupportMapFragment and get notified when the map is ready to be used.
        SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager().findFragmentById(R.id.map);
        mapFragment.getMapAsync(this);

        //gotoLocation(lat, lng, DEFAULTZOOM);
    }

    protected synchronized void buildGoogleApiClient() {
        mGoogleApiClient = new GoogleApiClient.Builder(this)
                .addConnectionCallbacks(this)
                .addOnConnectionFailedListener(this)
                .addApi(LocationServices.API)
                .build();
    }

    @Override
    protected void onStart() {
        super.onStart();
        mGoogleApiClient.connect();
    }

    @Override
    protected void onPause() {
        super.onPause();
        mGoogleApiClient.disconnect();
    }

    @Override
    protected void onPostCreate(Bundle savedInstanceState) {  //post create syncs hamburger icon with drawer state, switches to back on open
        super.onPostCreate(savedInstanceState);
        mDrawerToggle.syncState();
    }

    public void newsStory(View v) {         //this method runs when news story is clicked, opens web link
        Uri uri = Uri.parse("https://www.google.ie/webhp?sourceid=chrome-instant&ion=1&espv=2&es_th=1&ie=UTF-8#safe=off&tbm=nws&q=homeless+dublin"); // missing 'http://' will cause crashed
        Intent intent = new Intent(Intent.ACTION_VIEW, uri);
        startActivity(intent);

    }

    private void selectItemFromDrawer(int position) {       //this method looks after the options in the slide out menu.
        Fragment fragment = new PreferencesFragment();

        FragmentManager fragmentManager = getFragmentManager();
        fragmentManager.beginTransaction()
                .replace(R.id.mainContent, fragment)
                .commit();

        mDrawerList.setItemChecked(position, true);
        setTitle(mNavItems.get(position).mTitle);

        // Close the drawer
        mDrawerLayout.closeDrawer(mDrawerPane);
    }


    public void gotoLocation(Double latitude, Double longitude, float zoom) {
        LatLng ll = new LatLng(latitude, longitude);
        CameraUpdate update = CameraUpdateFactory.newLatLngZoom(ll, zoom);
        mMap.moveCamera(update);
    }

    public boolean onOptionsItemSelected(MenuItem item) {       //this toggles the hamburger menu
        // Pass the event to ActionBarDrawerToggle
        // If it returns true, then it has handled
        // the nav drawer indicator touch event
        if (mDrawerToggle.onOptionsItemSelected(item)) {
            return true;
        }

        // Handle your other action bar items...

        return super.onOptionsItemSelected(item);
    }

    /**
     * Manipulates the map once available.
     * This callback is triggered when the map is ready to be used.
     * This is where we can add markers or lines, add listeners or move the camera. In this case,
     * we just add a marker near Sydney, Australia.
     * If Google Play services is not installed on the device, the user will be prompted to install
     * it inside the SupportMapFragment. This method will only be triggered once the user has
     * installed Google Play services and returned to the app.
     */
    @Override
    public void onMapReady(GoogleMap googleMap) {

    }

    public boolean servicesOK(){    //checks if googlePlayServices is currently available
        int isAvailable = GooglePlayServicesUtil.isGooglePlayServicesAvailable(this);
        if(isAvailable == ConnectionResult.SUCCESS){
            return true;
        }
        else if(GooglePlayServicesUtil.isUserRecoverableError(isAvailable)){
            Dialog dialog = GooglePlayServicesUtil.getErrorDialog(isAvailable, this, GPS_ERRORDIALOG_REQUEST);
            dialog.show();
        }
        else{
            Toast.makeText(this, "Cant connect to play services", Toast.LENGTH_SHORT).show();
        }
        return false;
    }
    private boolean initMap(){
        if(mMap == null){
            SupportMapFragment mapFrag = (SupportMapFragment)getSupportFragmentManager().findFragmentById(R.id.map);
            mMap = mapFrag.getMap();
        }
        return (mMap != null);
    }

    @Override
    public void onConnected(Bundle connectionHint) {    //This is always null for some reason... erraahhhhhhhh!
        mLastLocation = LocationServices.FusedLocationApi.getLastLocation(mGoogleApiClient);
        if (mLastLocation != null) {
            latitude = mLastLocation.getLatitude();
            longitude = mLastLocation.getLongitude();
            Log.d(TAG, "These are the lat and long values: " + latitude +": " +longitude); //Test to see if lat & long update
        }
        else {
            Toast.makeText(this, "Lat & long still bleeeeedin null! aarhhhh: ", Toast.LENGTH_LONG).show();
        }
    }

    @Override
    public void onConnectionSuspended(int i) {

    }

    @Override
    public void onConnectionFailed(ConnectionResult connectionResult) {

    }
}
