<table><tr><td> <em>Assignment: </em> IT202 M2 PHP-HW</td></tr>
<tr><td> <em>Student: </em> Michael Sluka (mjs249)</td></tr>
<tr><td> <em>Generated: </em> 6/4/2023 1:03:25 PM</td></tr>
<tr><td> <em>Grading Link: </em> <a rel="noreferrer noopener" href="https://learn.ethereallab.app/homework/IT202-451-M23/it202-m2-php-hw/grade/mjs249" target="_blank">Grading</a></td></tr></table>
<table><tr><td> <em>Instructions: </em> <p>Make sure you have the dev/prod branches created before starting this assignment.</p><p><strong>Template Files</strong>&nbsp;You can find all 3 template files in this gist:&nbsp;<a href="https://gist.github.com/MattToegel/48b48377eaa1937c886b7840c449750a">https://gist.github.com/MattToegel/48b48377eaa1937c886b7840c449750a</a><br></p><p>Setup steps:</p><ol><li><code>git checkout dev</code></li><li><code>git pull origin dev</code></li><li><code>git checkout -b M2-PHP-HW</code></li></ol><p>You'll have 3 problems to save for this assignment.</p><p>Each problem you're given a template&nbsp;<strong>Do not edit anything in the template except where the comments tell you to</strong>.</p><p>The templates are done in such a way to make it easier to capture the output in a screenshot (if it's still not able to fit well, you can zoom out in your browser).</p><p>You'll copy each template into their own separate .php files, immediately git add, git commit these files (you can do it together) so we can capture the difference/changes between the templates and your additions. This part is required for full credit.</p><p>HW steps:</p><ol><li>Open VS Code at the root of your repository folder (you should see the Procfile and all from the Heroku setup)</li><li>In VS Code create a new folder/directory in public_html called M2</li><li>Create 3 new files in this new M2 folder (problem1.php, problem2.php, problem3.php)</li><li>Paste each template into their respective files</li><li><code>git add .</code></li><li><code>git commit -m "adding template baselines</code></li><li>Do the related work (you may do steps 8 and 9 as often as needed or you can do it all at once at the end)</li><li><code>git add .</code></li><li><code>git commit -m "completed hw"</code></li><li>When you're done push the branch<ol><li><code>git push origin M2-PHP-HW</code></li></ol></li><li>Go to heroku dev, and manually deploy the M2-PHP-HW branch</li><li>After it deploys go to&nbsp;<a href="https://ucid-dev.herokuapp.com/M2/problem1.php">https://ucid-dev.herokuapp.com/M2/problem1.php</a>&nbsp;(replace ucid with your ucid if you followed the setup instructions)</li><li>Update the URL to check that each problem file displays properly</li><li>Create the Pull Request with&nbsp;<strong>dev</strong>&nbsp;as base and&nbsp;<strong>M2-PHP-HW</strong>&nbsp;as compare</li><li>Create a new file in the M2 folder in VS Code called m2_submission.md</li><li>Fill out the below deliverable items, save the submission, and copy to markdown<ol><li>For this assignment you may get screenshots from your heroku dev instance, you do not need to move it to prod then come back and update it</li></ol></li><li>Paste the markdown into the m2_submission.md</li><li>add/commit/push the md file<ol><li><code>git add m2_submission.md</code></li><li><code>git commit -m "adding submission file"</code></li><li><code>git push origin M2-PHP-HW</code></li></ol></li><li>Merge the pull request from step 14</li><li>Create a new pull request with prod as base and dev as compare</li><li>Immediately create/merge/confirm, this is just to deploy it to prod and you don't need to adjust anything during this step</li><li>On your local machine sync the changes<ol><li><code>git checkout dev</code></li><li><code>git pull origin dev</code></li></ol></li><li>Submit the link to the m2_submission.md file from the prod branch to Canvas</li></ol><p><br></p></td></tr></table>
<table><tr><td> <em>Deliverable 1: </em> Problem 1 - Only output Odd values of the Array under "Odds output" </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="https://user-images.githubusercontent.com/54863474/211707773-e6aef7cb-d5b2-4053-bbb1-b09fc609041e.png"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> 2 Screenshots: Clearly screenshot the output of Problem 1 and show the edited code</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fmjs249%2F2023-06-04T16.26.57PhpProblem1_Code.JPG.webp?alt=media&token=bff6bd21-0e5f-411f-ab9e-739e2b300fb0"/></td></tr>
<tr><td> <em>Caption:</em> <p>code for problem 1<br></p>
</td></tr>
<tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fmjs249%2F2023-06-04T16.26.08PhpProblem1_Output.JPG.webp?alt=media&token=e9c078df-c2ec-42d0-a970-e4a55a64ecc0"/></td></tr>
<tr><td> <em>Caption:</em> <p>output for problem 1<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Describe how you solved the problem</td></tr>
<tr><td> <em>Response:</em> <p>I solved this problem by implementing a for loop that iterates through the<br>arrays and checks if the value is not divisible by 2. If the<br>value is not divisible by 2, the output is printed. The division provides<br>only odd numbers.&nbsp;<br></p><br></td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 2: </em> Problem 2 - Only output the sum/total of the array values by assigning it to the $total variable (the number must end in 2 decimal places, if it ends in 1 it must have a 0 at the end) </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="https://user-images.githubusercontent.com/54863474/211707773-e6aef7cb-d5b2-4053-bbb1-b09fc609041e.png"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> 2 Screenshots: Clearly screenshot the output of Problem 2 showing the data and show the edited code</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fmjs249%2F2023-06-04T16.29.08PhpProblem2_Code.JPG.webp?alt=media&token=92557d8e-6b1c-496a-9281-d6c795ec5f5e"/></td></tr>
<tr><td> <em>Caption:</em> <p>Problem 2 code. <br></p>
</td></tr>
<tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fmjs249%2F2023-06-04T16.29.10PhpProblem2_Output.JPG.webp?alt=media&token=ffe90d94-fe94-4968-8a8a-beae27536141"/></td></tr>
<tr><td> <em>Caption:</em> <p>Problem 2 output. <br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Describe how you solved the problem</td></tr>
<tr><td> <em>Response:</em> <p>The totaling logic was performed by iterating though each value in the array,<br>and adding it to the variable $total. The rounding logic was performed by<br>using number_format() in which I specified 2 decimal places for the total variable.<br>The only edit I needed was to add the $ sign in front<br>of the total for it to display as currency would.&nbsp;&nbsp;<br></p><br></td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 3: </em> Problem 3 - Output the given values as positive under the "Positive Output" message (the data otherwise shouldn't change) </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="https://user-images.githubusercontent.com/54863474/211707773-e6aef7cb-d5b2-4053-bbb1-b09fc609041e.png"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> 2 Screenshots: Clearly screenshot the output of Problem 3 showing the data and show the code</td></tr>
<tr><td><table><tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fmjs249%2F2023-06-04T16.33.37PhpProblem3_Code.JPG.webp?alt=media&token=0727d49e-073a-444a-b424-0864600e0e66"/></td></tr>
<tr><td> <em>Caption:</em> <p>Problem 3 Code<br></p>
</td></tr>
<tr><td><img width="768px" src="https://firebasestorage.googleapis.com/v0/b/learn-e1de9.appspot.com/o/assignments%2Fmjs249%2F2023-06-04T16.33.45PhpProblem3_Output.JPG.webp?alt=media&token=3ef2bac2-aa3b-465c-b9ce-8e6f1129b7f8"/></td></tr>
<tr><td> <em>Caption:</em> <p>Problem 3 output<br></p>
</td></tr>
</table></td></tr>
<tr><td> <em>Sub-Task 2: </em> Describe how you solved the problem</td></tr>
<tr><td> <em>Response:</em> <p>The positive conversion was done by using a for loop to iterate through<br>each value in the array, and assigning it to the absolute value of<br>the number.&nbsp;&nbsp;<br></p><br></td></tr>
</table></td></tr>
<table><tr><td> <em>Deliverable 4: </em> Misc Items </td></tr><tr><td><em>Status: </em> <img width="100" height="20" src="https://user-images.githubusercontent.com/54863474/211707773-e6aef7cb-d5b2-4053-bbb1-b09fc609041e.png"></td></tr>
<tr><td><table><tr><td> <em>Sub-Task 1: </em> Add the prod URL for problem1.php (remember you can assume this based on how the domain gets built (i.e., ucid-prod.herokuapp.com/...)</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://.mjs249-prod.herokuapp.com/M2/problem1.php">https://.mjs249-prod.herokuapp.com/M2/problem1.php</a> </td></tr>
<tr><td> <em>Sub-Task 2: </em> Add the prod URL for problem2.php (remember you can assume this based on how the domain gets built (i.e., ucid-prod.herokuapp.com/...)</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://.mjs249-prod.herokuapp.com/M2/problem2.php">https://.mjs249-prod.herokuapp.com/M2/problem2.php</a> </td></tr>
<tr><td> <em>Sub-Task 3: </em> Add the prod URL for problem3.php (remember you can assume this based on how the domain gets built (i.e., ucid-prod.herokuapp.com/...)</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://.mjs249-prod.herokuapp.com/M2/problem3.php">https://.mjs249-prod.herokuapp.com/M2/problem3.php</a> </td></tr>
<tr><td> <em>Sub-Task 4: </em> Pull Request URL for M2-PHP-HW to dev</td></tr>
<tr><td> <a rel="noreferrer noopener" target="_blank" href="https://github.com/mjs249/IT202-451/pull/14">https://github.com/mjs249/IT202-451/pull/14</a> </td></tr>
<tr><td> <em>Sub-Task 5: </em> Talk about what you learned, any issues you had, how you resolve them</td></tr>
<tr><td> <em>Response:</em> <p>I learned how to manipulate array values in PHP. I still have issues<br>with getting used to Git/Github, getting error messages when trying to push into<br>a branch, which it says that my remote and local repositories have different<br>contents. I used force push to sync it all back together (although in<br>the future I realize I should refrain from doing so).&nbsp;<br></p><br></td></tr>
</table></td></tr>
<table><tr><td><em>Grading Link: </em><a rel="noreferrer noopener" href="https://learn.ethereallab.app/homework/IT202-451-M23/it202-m2-php-hw/grade/mjs249" target="_blank">Grading</a></td></tr></table>
