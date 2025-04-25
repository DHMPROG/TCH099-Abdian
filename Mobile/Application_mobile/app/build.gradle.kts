plugins {
    alias(libs.plugins.android.application)
}

android {
    namespace = "com.todoran.reservation_billet_avion"
    compileSdk = 35

    defaultConfig {
        applicationId = "com.todoran.reservation_billet_avion"
        minSdk = 24
        targetSdk = 34
        versionCode = 1
        versionName = "1.0"

        testInstrumentationRunner = "androidx.test.runner.AndroidJUnitRunner"
    }

    buildTypes {
        release {
            isMinifyEnabled = false
            proguardFiles(
                getDefaultProguardFile("proguard-android-optimize.txt"),
                "proguard-rules.pro"
            )
        }
    }
    compileOptions {
        sourceCompatibility = JavaVersion.VERSION_11
        targetCompatibility = JavaVersion.VERSION_11
    }
}

dependencies {

    implementation(libs.appcompat)
    implementation(libs.material)
    implementation(libs.activity)
    implementation(libs.constraintlayout)
    testImplementation(libs.junit)
    androidTestImplementation(libs.ext.junit)
    androidTestImplementation(libs.espresso.core)
    implementation("com.google.android.material:material:1.12.0") //Material
    implementation ("androidx.cardview:cardview:1.0.0") //CardView
    implementation("com.fasterxml.jackson.core:jackson-databind:2.16.1")

    implementation("com.squareup.okhttp3:okhttp:5.0.0-alpha.2")
    implementation ("com.google.zxing:core:3.5.1")
    implementation ("com.journeyapps:zxing-android-embedded:4.3.0")

}