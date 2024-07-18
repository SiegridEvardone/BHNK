let model, webcam, maxPredictions;

    // Load the Teachable Machine model
    async function loadModel() {
        const URL = 'model/';  // Path to your model files
        const modelURL = URL + 'model.json';
        const metadataURL = URL + 'metadata.json';

        try {
            model = await tmImage.load(modelURL, metadataURL);
            maxPredictions = model.getTotalClasses();
            console.log("Model loaded successfully.");
        } catch (error) {
            console.error("Error loading model:", error);
        }
    }

    // Start the webcam and perform face recognition
    async function startFaceLogin() {
        const video = document.getElementById('video');
        const status = document.getElementById('status');

        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
            status.innerText = 'Webcam enabled. Please wait...';
            const flip = true;

            webcam = new tmImage.Webcam(224, 224, flip);  // width, height, flip
            await webcam.setup();  // request access to the webcam
            await webcam.play();
            window.requestAnimationFrame(loop);

            async function loop() {
                webcam.update();  // update the webcam frame

                if (model && webcam.canvas) {
                    const prediction = await model.predict(webcam.canvas);

                    // Find the prediction with the highest probability
                    const maxPrediction = prediction.reduce((max, p) => p.probability > max.probability ? p : max, prediction[0]);

                    // Redirect based on prediction result
                    if (maxPrediction.className === "admin" && maxPrediction.probability > 0.9) {
                        status.innerText = 'Face recognized. Logging in...';
                        await delay(3000);  // Delay for 3 seconds
                        alert('Welcome Admin!');
                        window.location.href = 'admin/index.php';  // Redirect upon successful recognition
                    } else {
                        status.innerText = 'Face not recognized. Please try again.';
                    }
                }

                window.requestAnimationFrame(loop);
            }
        } catch (error) {
            console.error('Error accessing webcam:', error);
            status.innerText = 'Error accessing webcam. Please enable and try again.';
        }
    }

    // Delay function
    function delay(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    loadModel();  // Load the model when the page loads