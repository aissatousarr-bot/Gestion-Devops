pipeline {
    agent any

    environment {
        DOCKER_IMAGE = "school-management-app:latest"
        GIT_REPO = "https://github.com/Aissatouh/Application-School-Management.git"
    }

    stages {
        stage('Récupération du code source') {
            steps {
                git url: "${GIT_REPO}", branch: 'main'
            }
        }

        stage('Installation des dépendances Laravel') {
            steps {
                sh 'composer install'
                sh 'php artisan key:generate'
                sh 'php artisan migrate --force'
            }
        }

        stage('Installation & build du frontend Node.js') {
            steps {
                sh 'npm install'
                sh 'npm run build'
            }
        }

        stage('Tests unitaires & IHM') {
            steps {
                sh 'php artisan test'    // Tests Laravel
                sh 'npm test'            // Tests Selenium pour le frontend
            }
        }

        stage('Analyse de la qualité logicielle') {
            steps {
                sh 'sonar-scanner -Dsonar.projectKey=school-management -Dsonar.sources=./ -Dsonar.host.url=http://localhost:9000 -Dsonar.login=votre_token'
            }
        }

        stage('Création de l\'image Docker') {
            steps {
                sh 'docker build -t ${DOCKER_IMAGE} .'
            }
        }

        stage('Push de l\'image Docker') {
            steps {
                sh 'docker tag ${DOCKER_IMAGE} mon-registry/${DOCKER_IMAGE}'
                sh 'docker push mon-registry/${DOCKER_IMAGE}'
            }
        }

        stage('Déploiement sur Kubernetes') {
            steps {
                sh 'kubectl apply -f deployment.yaml'
            }
        }
    }

    post {
        success {
            echo 'Déploiement réussi !'
        }
        failure {
            echo 'Échec du déploiement !'
        }
    }
}
