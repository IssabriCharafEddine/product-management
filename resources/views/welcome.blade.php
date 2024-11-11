<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backend Engineer Assessment - Product Management System</title>
    <style>
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 800px;
            width: 90%;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .container:hover {
            transform: translateY(-10px);
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 1rem;
            font-size: 2.5em;
        }

        .highlight {
            color: #e74c3c;
            font-weight: bold;
            display: inline-block;
            animation: pulse 2s infinite;
        }

        .tech-stack {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin: 1rem 0;
            flex-wrap: wrap;
        }

        .tech-item {
            background-color: #3498db;
            color: #ffffff;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .tech-item:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .features {
            text-align: left;
            margin-top: 1rem;
        }

        .feature-item {
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            opacity: 0;
            transform: translateX(-20px);
            transition: all 0.5s ease;
        }

        .feature-item.show {
            opacity: 1;
            transform: translateX(0);
        }

        .feature-icon {
            font-size: 1.5em;
            margin-right: 10px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 1;
            }
            20% {
                transform: scale(25, 25);
                opacity: 1;
            }
            100% {
                opacity: 0;
                transform: scale(40, 40);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to the <span class="highlight">Backend Developer Challenge for Laravel Position at </span></h1>
        <h3>Im'enSe</h3>
        
        <div class="tech-stack">
            <span class="tech-item">PHP</span>
            <span class="tech-item">Laravel</span>
            <span class="tech-item">MySQL</span>
            <span class="tech-item">Docker</span>
        </div>
        
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const features = document.querySelectorAll('.feature-item');
            features.forEach((feature, index) => {
                setTimeout(() => {
                    feature.classList.add('show');
                }, 300 * index);
            });

            const techItems = document.querySelectorAll('.tech-item');
            techItems.forEach(item => {
                item.addEventListener('mouseover', () => {
                    item.style.backgroundColor = getRandomColor();
                });
            });

            function getRandomColor() {
                const letters = '0123456789ABCDEF';
                let color = '#';
                for (let i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }
        });
    </script>
</body>
</html>