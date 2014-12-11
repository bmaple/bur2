#include <iostream>
#include <string>
#include <vector>
#include <algorithm>

using namespace std;

class Dynamic 
{
private:
	vector <vector <int> > plots; //vector for storing plot data
	vector <vector <char> > image;
	int n; //number of columns
	int value1; //value for top row item
	int value2; //value for bottom row item
	bool isFirstTry;
public:
	Dynamic() 
	{
		
		plots.clear();
		plots.resize(2);
		image.clear();
		image.resize(2);

		n = -1;
		value1 = 0;
		value2 = 0;	
		isFirstTry = true;
	}

	void input() 
	{
		
		while (n != 0) 
		{
			plots.clear();
			image.clear();
			cin >> n;
			plots.resize(2, vector<int>(n));
			image.resize(2, vector<char>(n));

			for (int j = 0; j < n; j++) 
			{
				cin >> value1 >> value2;
				plots[0][j] = value1;
				plots[1][j] = value2;
				image[0][j] = ' ';
				image[1][j] = ' ';
			}
			cout<<maxMerge();
			print();
		}
	}
	
	int maxMerge()
	{
		int sum = 0;
		int i = plots[0].size()-1;
		isFirstTry = true;
		while (i >= 0)
		{

			if (i == 0)
			{
				sum += plots[0][i] * plots[1][i];
				image[0][i] = '|';
				image[1][i] = '|';
			}
			//Flush recursion
			//Case 1 Flush(i) = flush(i - 1) + A[1][i]*A[2][i](add the red)
			else if ( (plots[0][i] * plots[1][i] >= plots[0][i] * plots[0][i - 1] && plots[0][i] * plots[1][i] >= plots[1][i] * plots[1][i - 1]) || (plots[0][i-1]*plots[1][i-1] >= (plots[0][i]*plots[0][i-1] + plots[1][i]*plots[1][i-1]) && i < 2) ||((plots[0][i-1]*plots[1][i-1] >= (plots[0][i]*plots[0][i-1] + plots[1][i]*plots[1][i-1])) && (i >=2 && plots[0][i-1]*plots[1][i-1] >= (plots[0][i-1]*plots[0][i-2] + plots[1][i-1]*plots[1][i-2]))) ) 
			//These Flush statements check the vertical pair against the two horizontal pairs, going backwards through the plots, and reacts accordingly.
			{
				sum += plots[0][i] * plots[1][i];
				image[0][i] = '|';
				image[1][i] = '|';
			}			
			//Case 2 Flush(i) = flush(i - 2) + A[1][i - 1] * A[1][i] + A[2][i - 1] * A[2][i](add red and yellow)
			/*else if ((plots[0][i] * plots[1][i] <= plots[0][i] * plots[0][i - 1]) && (plots[0][i] * plots[1][i] <= plots[1][i] * plots[1][i - 1]) &&
				(plots[0][i-1] * plots[1][i-1] <= plots[0][i] * plots[0][i - 1]) && (plots[0][i-1] * plots[1][i-1] <= plots[1][i] * plots[1][i - 1]))
			*/
			else if ( (plots[0][i]*plots[0][i-1] + plots[1][i]*plots[1][i-1]) >= (plots[0][i]*plots[1][i] + plots[0][i-1]*plots[1][i-1]) 
					&& ((i <= 2 && plots[0][i] != 0 && plots[1][i] != 0) || (i == 3 && ((plots[0][i-2]*plots[0][i-3] + plots[1][i-2]*plots[1][i-3]) >= (plots[0][i-2]*plots[1][i-2] + plots[0][i-3]*plots[1][i-3])))
					|| (i >= 4 && plots[1][i-4]*plots[1][i-3] <= plots[1][i-2]*plots[1][i-1] && plots[0][i-4]*plots[0][i-3] <= plots[0][i-2]*plots[0][i-1]) ) )
			{
				sum += (plots[0][i] * plots[0][i-1] + plots[1][i]*plots[1][i-1]);
				image[0][i] = '-';
				image[0][i-1] = '-';
				image[1][i] = '-';
				image[1][i - 1] = '-';
				i--;
			}
			//Case 3 Flush(i) = top(i - 1) + A[1][i] * A[2][i](add the red)
			else if ((plots[0][i] * plots[1][i] > plots[0][i] * plots[0][i - 1]) && (plots[0][i] * plots[1][i] > plots[1][i] * plots[1][i - 1]) && plots[0][i - 1] < plots[1][i - 1])
			{
				plots[1][i - 1] = 0;
				sum += plots[0][i] * plots[1][i];
				image[0][i] = '|';
				image[1][i] = '|';
			}
			//Case 4 Flush(i) = bot(i - 1) + A[1][i] * A[2][i](add the red)
			else if ((plots[0][i] * plots[1][i] > plots[0][i] * plots[0][i - 1]) && (plots[0][i] * plots[1][i] <= plots[1][i] * plots[1][i - 1]) && plots[1][i - 1] < plots[0][i-1])
			{
				plots[0][i - 1] = 0;
				sum += plots[0][i] * plots[1][i];
				image[0][i] = '|';
				image[1][i] = '|';
			}			
			//Case 5 Flush(i) = top(i - 2) + A[1][i - 1] * A[1][i] + A[2][i - 1] * A[2][i]
			//else if ((i > 2 && plots[0][i] * plots[1][i] + plots[0][i - 1] * plots[1][i - 1] <= plots[0][i] * plots[0][i - 1] + plots[1][i] * plots[1][i - 1]) && (plots[1][i - 2] * plots[1][i - 3] < plots[0][i - 2] * plots[0][i - 3]))
			else if (i > 2 && (plots[0][i]*plots[0][i-1] + plots[1][i]*plots[1][i-1]) >= (plots[0][i]*plots[1][i] + plots[0][i-1]*plots[1][i-1])
				&& (plots[1][i - 2] * plots[1][i - 3] < plots[0][i - 2] * plots[0][i - 3])
				&& (plots[0][i-3]*plots[0][i-2] >= plots[0][i-2]*plots[0][i-1]) )
			{
				plots[1][i - 2] = 0;
				sum += (plots[0][i - 1] * plots[0][i] + plots[1][i - 1] * plots[1][i]);
				image[0][i] = '-';
				image[0][i - 1] = '-';
				image[1][i] = '-';
				image[1][i - 1] = '-';
				i--;
			}
			//Case 6 Flush(i) = bot(i-2) + A[1][i-1]*A[1][i]+A[2][i-1]*A[2][i]
			//else if ((i > 2 && plots[0][i] * plots[1][i] + plots[0][i - 1] * plots[1][i - 1] <= plots[0][i] * plots[0][i - 1] + plots[1][i] * plots[1][i - 1]) && plots[0][i - 2] * plots[0][i - 3] < plots[1][i - 2] * plots[1][i - 3])
			else if (i > 2 && (plots[0][i]*plots[0][i-1] + plots[1][i]*plots[1][i-1]) >= (plots[0][i]*plots[1][i] + plots[0][i-1]*plots[1][i-1])
				&& (plots[0][i - 2] * plots[0][i - 3] < plots[1][i - 2] * plots[1][i - 3])
				&& plots[1][i-3]*plots[1][i-2] >= plots[1][i-2]*plots[1][i-1])
			{
				plots[0][i - 2] = 0;
				sum += (plots[0][i - 1] * plots[0][i] + plots[1][i - 1] * plots[1][i]);
				image[0][i] = '-';
				image[0][i - 1] = '-';
				image[1][i] = '-';
				image[1][i - 1] = '-';
				i--;
			}
			else if (i == plots[0].size() - 1 && isFirstTry == true) // to check if number in first col needs to be 0
			{
				if (plots[0][i] > plots[1][i])
				{
					plots[1][i] = 0;
				}
				else
				{
					plots[0][i] = 0;		
				}
				isFirstTry = false;
				i++;
			}
			//Cases for top
			//Case 1. top(i) = bot(i - 1) + A[1][i - 1] * A[1][i]
			else if (i > 1 && plots[1][i] == 0 && plots[1][i - 1] < plots[0][i - 2])
			{
				sum += plots[0][i-1] * plots[0][i];
				image[0][i] = '-';
				image[0][i - 1] = '-';
			}		
			//Case 2. top(i) = top(i - 2) + A[1][i - 1] * A[1][i] + A[2][i - 2] * A[2][i - 1]
			else if (i > 2 && plots[1][i] == 0 && plots[1][i - 1] > plots[0][i - 2] && (plots[0][i - 2] > plots[1][i - 3] || (i > 3 && plots[0][i-2]*plots[0][i-3] < plots[1][i-3]*plots[1][i-4])) )
			{
				sum += (plots[0][i-1] * plots[0][i] + plots[1][i-2]*plots[1][i-1]);
				image[0][i] = '-';
				image[0][i - 1] = '-';
				image[1][i - 1] = '-';
				image[1][i - 2] = '-';
				plots[1][i - 2] = 0;
				i--;
			}			
			//Case 3. top(i) = flush(i - 3) + A[1][i - 1] * A[1][i] + A[2][i - 2] * A[2][i - 1]
			else if (i >= 2 && plots[1][i] == 0 && plots[1][i - 1] > plots[0][i - 2] && ( i == 2 || plots[0][i - 2] < plots[1][i - 3]) )
			{
				plots[0][i - 2] = 0;
				sum += (plots[0][i - 1] * plots[0][i] + plots[1][i - 2] * plots[1][i - 1]);
				image[0][i] = '-';
				image[0][i - 1] = '-';
				image[1][i - 1] = '-';
				image[1][i - 2] = '-';
				i -= 2;
			}			
			//Cases for bot
			//Case 1. bot(i) = tot(i - 1) + A[3][i - 1] * A[2][i]Max Merge Recursion
			else if (i > 1 && plots[0][i] == 0 && plots[0][i - 1] < plots[1][i - 2])
			{
				sum += plots[1][i - 1] * plots[1][i];
				image[1][i] = '-';
				image[1][i - 1] = '-';
			}			
			//Case 2. bot(i) = top(i - 2) + A[2][i - 1] * A[2][i] + A[1][i - 2] * A[1][i - 1]
			else if (i > 2 && plots[0][i] == 0 && plots[0][i - 1] > plots[1][i - 2] && (plots[1][i - 2] > plots[0][i - 3] || (i > 3 && plots[1][i-2]*plots[1][i-3] < plots[0][i-3]*plots[0][i-4])) )
			{
				sum += (plots[1][i - 1] * plots[1][i] + plots[0][i - 2] * plots[0][i - 1]);
				image[1][i] = '-';
				image[1][i - 1] = '-';
				image[0][i - 1] = '-';
				image[0][i - 2] = '-';
				plots[0][i - 2] = 0;
				i--;
			}			
			//Case 3. bot(i) = flush(i - 3) + A[2][i - 1] * A[2][i] + A[1][i - 2] * A[1][i - 1]
			else if (i >= 2 && plots[0][i] == 0 && plots[0][i - 1] > plots[1][i - 2] && ( i == 2 || plots[1][i - 2] < plots[0][i - 3]) )
			{
				plots[1][i - 2] = 0;
				sum += (plots[1][i - 1] * plots[1][i] + plots[0][i - 2] * plots[0][i - 1]);
				image[1][i] = '-';
				image[1][i - 1] = '-';
				image[0][i - 1] = '-';
				image[0][i - 2] = '-';
				i -= 2;
			}	
			i--;
		}
		return sum;
	}

	void print()
	{
		cout << "\n";
		for (unsigned i = 0; i < image[0].size(); i++)
		{
			cout << image[0][i];
		}
		cout << "\n";
		for (unsigned i = 0; i < image[0].size(); i++)
		{
			cout << image[1][i];
		}
		cout << "\n";
	}

};


int main() 
{
	Dynamic programming; //haha
	programming.input();
	return 0;
}