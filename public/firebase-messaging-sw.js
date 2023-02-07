/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js');
   
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
    apiKey: "AAAANP0-ZG8:APA91bEVVWHQDnXwmiqSoKGNrBP2LMxGD-Qi34nXTU4yI3JRj3vQOvuQSND0m43m2lxLMK5KHkM8ZUY5_Mmd8gIQrbCNKKQvWgAZDWrHiBGWSvpi6jOSV5soalVDXG84Ltm-AtqXClem",
    authDomain: "test-firebase-9be0c.firebaseapp.com",
    projectId: "test-firebase-9be0c",
    storageBucket: "test-firebase-9be0c.appspot.com",
    messagingSenderId: "227587023983",
    appId: "1:227587023983:web:f79e3b0b65a47a12a0599a",
    measurementId: "G-RCCG0FXDZ0"
    });
  
/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload,
    );
    /* Customize notification here */
    const notificationTitle = "Background Message Title";
    const notificationOptions = {
        body: "Background Message body.",
        icon: "/itwonders-web-logo.png",
    };
  
    return self.registration.showNotification(
        notificationTitle,
        notificationOptions,
    );
});