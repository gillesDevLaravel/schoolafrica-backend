// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: "AIzaSyCd7hb0wlTSKIdb1lCzALmo0D61ZeE9rqA",
    authDomain: "msschool-40db5.firebaseapp.com",
    projectId: "msschool-40db5",
    storageBucket: "msschool-40db5.appspot.com",
    messagingSenderId: "456751925137",
    appId: "1:456751925137:web:57045acb13b38b51697c30",
    measurementId: "G-M17EL0XPBN"
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log("Message received.", payload);
    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png",
    };
    return self.registration.showNotification(
        title,
        options,
    );
});





/*
// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyCd7hb0wlTSKIdb1lCzALmo0D61ZeE9rqA",
  authDomain: "msschool-40db5.firebaseapp.com",
  projectId: "msschool-40db5",
  storageBucket: "msschool-40db5.appspot.com",
  messagingSenderId: "456751925137",
  appId: "1:456751925137:web:57045acb13b38b51697c30",
  measurementId: "G-M17EL0XPBN"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);

*/
