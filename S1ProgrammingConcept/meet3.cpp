#include <iostream>
using namespace std;

int main() {
    double height, BMI;
    int weight;
    
    cout << "Input your height in meters: ";
    cin >> height;
    cout << "Input your weight in kilograms: ";
    cin >> weight;
    BMI = weight / (height * height);
    cout << "Your BMI is: " << BMI << endl;


    if (BMI < 16)
        cout << "Serious underweight";
    else if (BMI >= 16 && BMI < 18.5)
        cout << "Underweight";
    else if (BMI >= 18.5 && BMI < 24.9)
        cout << "Normal weight";
    else if (BMI >= 25 && BMI < 29.9)
        cout << "Overweight";
    else if (BMI >= 30 && BMI < 34.9)
        cout << "Serious overweight";
    else
        cout << "Gravely overweight";
    
    return 0;
}
