pipeline {
  options {
    buildDiscarder(logRotator(numToKeepStr: '10'))
    disableConcurrentBuilds()
  }
  agent any
  stages {
    stage('Prepare') {
      steps {
        sh 'composer install'
      }
    }
    stage('Bring up') {
      steps {
        sh 'docker-compose up -d'
      }
    }
    stage('Test') {
      steps {
        sh 'docker-compose exec php /app/testing/run'
      }
    }
    stage('Tear down') {
      steps {
        sh 'docker-compose down'
      }
    }
  }
}
