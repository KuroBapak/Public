#include <iostream>
using namespace std;

int main() {
    char AnswerKey;
    char UserAnswer;

    cout << "Q.1 What is 5+3?" << endl;
    cout << "A.6 B.8 C.7 D.9" << endl;
    AnswerKey = 'B';
    cin >> UserAnswer;

    if (UserAnswer == AnswerKey) {
        cout << "Answer is correct, next exercise..." << endl;
    } else {
        cout << "Incorrect answer. Please try again." << endl;
        return 1;
    }

    cout << "Q.2 What is 7*7?" << endl;
    cout << "A.4 B.9 C.49 D.0" << endl;

    AnswerKey = 'C';
    cin >> UserAnswer;

    if (UserAnswer == AnswerKey) {
        cout << "Answer is correct, next exercise..." << endl;
    } else {
        cout << "Incorrect answer. Please try again." << endl;
        return 1;
    }
    return 0; 
}
