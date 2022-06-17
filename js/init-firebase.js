const firebaseConfig = {
  apiKey: "AIzaSyBYLETCmTlmeSbYjkP38ZgGGkt_Y2HAZag",
  authDomain: "webhook-app-1435b.firebaseapp.com",
  projectId: "webhook-app-1435b",
  storageBucket: "webhook-app-1435b.appspot.com",
  messagingSenderId: "824956964895",
  appId: "1:824956964895:web:a8eba545d966f9a440052a",
  measurementId: "G-2N62ZKRZ5W",
  databaseURL:
    "https://webhook-app-1435b-default-rtdb.asia-southeast1.firebasedatabase.app/",
};
// Initialize Firebase
const app = firebase.initializeApp(firebaseConfig);
const firebaseDb = app.database();
const notificationRef = firebaseDb.ref("/notification");
