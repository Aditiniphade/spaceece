pipeline {
    agent any 
    stages {
        stage('Pull') { 
            steps {
                 git branch: 'main', url: 'https://github.com/Aditiniphade/spaceece.git' 
            }
        }
        stage('Build') { 
            steps {
                // Run a Maven build
               sh 'mvn clean install'
            }
        }
        stage('test') { 
            steps {
                 // Run test {
             sh 'mvn test'
                }
            }
        }
        stage('Deploy') { 
            steps {
               deploy adapters: [tomcat8(credentialsId: 'tomcat-cred', path: '', url: 'http://65.2.180.102:8080')], contextPath: '/', onFailure: false, war: '*/.war'
            }
        }        
    }
}
