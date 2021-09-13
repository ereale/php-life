![Screenshot](https://raw.githubusercontent.com/ereale/php-life/main/images/php-life.gif)

# Code Review
1. Explain the Game of life rules to the candidate, make sure they understand it.
2. Walk through the program and its various parts with the candidate. Have the candidate read the code and explain what it does.
3. Explain to the candidate to treat this as a regular code review where they are allowed to ask questions to clarify code/logic and that they should aim to make suggestions for how this code can be improved/refactored.


## Required
- Candidate should be able to read and explain each section of the code.
- Candidate should be able to highlight parts of the code that is not considered good practice, e.g. code-smells, anti-patterns.
- Candidate should suggest places for validations in the code.
- Candidate should be able to discuss how they would go about adding tests to the code, e.g. Unit, Integration...

## Optional
- Candidate should be able to identify optimizations that can be made in the code.
  -  Focus on optimizing the parts that matter, i.e. use of profiling to identify bottle-necks.
    - Looping through each cell.
    - Counting alive neighbours for each cell.
