#!/usr/bin/env node

const fs = require('fs');
const path = require('path');

// Path to the task-viewer.html file
const taskViewerPath = path.join(__dirname, '..', 'project-planning', 'task-viewer.html');

// Read the file content
let content = fs.readFileSync(taskViewerPath, 'utf8');

// Extract the JSON data
const jsonMatch = content.match(/const data = (\{[\s\S]*?\});/);
if (!jsonMatch) {
  console.error('Could not extract JSON data from task-viewer.html');
  process.exit(1);
}

// Parse the JSON data
let jsonData;
try {
  jsonData = eval(`(${jsonMatch[1]})`);
} catch (error) {
  console.error('Error parsing JSON data:', error);
  process.exit(1);
}

// Count the number of tasks and priorities changed
let totalTasks = 0;
let changedTasks = 0;

// Update all priorities to "None"
for (const category of jsonData.categories) {
  for (const task of category.tasks) {
    totalTasks++;
    if (task.priority !== "None") {
      console.log(`Changing priority of task ${task.id}: ${task.title} from "${task.priority}" to "None"`);
      task.priority = "None";
      changedTasks++;
    }
  }
}

// Convert the JSON data back to a string
const updatedJsonString = JSON.stringify(jsonData, null, 2);

// Replace the JSON data in the file content
const updatedContent = content.replace(
  /const data = \{[\s\S]*?\};/,
  `const data = ${updatedJsonString};`
);

// Write the updated content back to the file
fs.writeFileSync(taskViewerPath, updatedContent, 'utf8');

console.log(`\nPriority update complete!`);
console.log(`Total tasks: ${totalTasks}`);
console.log(`Tasks updated: ${changedTasks}`);
