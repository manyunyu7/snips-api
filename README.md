# Contributing
When contributing to this repository, please first discuss the change you wish to make via issue, email, or any other method with the maintainers (@manyunyu7) of this repository before making a change.


## GitFlow
For contributing to this codebase, please use the gitlow that used in DEV. For that, please refer to this [file](/Gitflow.md).
- create branch with hypen-case, example : feature-user-management
- develop on that branch
- merge with branch develop

branch naming : 
- for Developing feature use : feature-example
- for bugfixing use : bugfix-example
- for feedback from QA : feedback-example
- for hotfix after prod : hotfix-example

commit message : 
- title : main feature that developed
- message : explanation of what you doing

## Merge Request Process
Keep in this in mind when proposing a new merge request:

| Item | Description | 
| ---- | ----------- |
| Title | Clear title that represents overall of your activity and the story you finished |
| Description | Description the things you do in this MR and **has to provide** information like: <br/>- Issue number<br/>- Overview<br/>- Step to Test |
| Notes | *[Optional]* <br/>Other things that the reviewer should know |

### Commit Message Guide
Please refer to this [link](https://gist.github.com/stephenparish/9941e89d80e2bc58a153) for commit message convention.

### Things that being reviewed
- **MR Proposal**, submitted MR proposal meets with the MR Specification described above
- **Code Quality Aspects**, code complies with the Kotlin and Android Convention
- **Functionality, Flow and Algorithm**, the code is efficient and able to run well and as expected

> Adding new dependency **should** always ask maintainers for approval

