<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-analytics.js"></script>
<script>
    var firebaseConfig = {
        messagingSenderId: "867113437035",
        apiKey: "AIzaSyDQYUrYhQyBZx_ZneLzTouz6v7H9mZVlmE",
        authDomain: "fcm-demo-f5cc3.firebaseapp.com",
        databaseURL: "https://fcm-demo-f5cc3.firebaseio.com",
        projectId: "fcm-demo-f5cc3",
        storageBucket: "fcm-demo-f5cc3.appspot.com",
        appId: "1:867113437035:web:3e21039080ab6a961dee2e",
        // measurementId: "G-MP1GQDZ18D"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    
    const messaging = firebase.messaging();
    
    // Get registration token. Initially this makes a network call, once retrieved
    // subsequent calls to getToken will return from cache.
    messaging.getToken({vapidKey: 'BMiGPhLg3FKWYq0kDvjvvhoH8hlZcCnf0YjJsMZBKz1_hNNXd_nXhwl_f7m4KKE5Se1uJoII9IRXB68zJcJKe-4'}).then((currentToken) => {
      if (currentToken) {
        sendTokenToServer(currentToken);
        updateUIForPushEnabled(currentToken);
      } else {
        // Show permission request.
        console.log('No registration token available. Request permission to generate one.');
        // Show permission UI.
        // updateUIForPushPermissionRequired();
        // setTokenSentToServer(false);
      }
    }).catch((err) => {
      console.log('An error occurred while retrieving token. ', err);
    //   showToken('Error retrieving registration token. ', err);
    //   setTokenSentToServer(false);
    });
</script>