let tasks = [];

function addTask() {
  const taskInput = document.getElementById("new-task");
  const taskText = taskInput.value.trim();

  if (taskText) {
    tasks.push(taskText);
    taskInput.value = "";
    renderTasks();
  }
}

function renderTasks() {
  const taskList = document.getElementById("task-list");
  taskList.innerHTML = "";

  tasks.forEach((task, index) => {
    const listItem = document.createElement("li");

    const taskSpan = document.createElement("span");
    taskSpan.textContent = task;

    const editButton = document.createElement("button");
    editButton.textContent = "Edit";
    editButton.classList.add("edit-btn");
    editButton.onclick = function () {
      editTask(index);
    };

    const deleteButton = document.createElement("button");
    deleteButton.textContent = "Delete";
    deleteButton.onclick = function () {
      deleteTask(index);
    };

    listItem.appendChild(taskSpan);
    listItem.appendChild(editButton);
    listItem.appendChild(deleteButton);
    taskList.appendChild(listItem);
  });
}

function deleteTask(index) {
  tasks.splice(index, 1);
  renderTasks();
}

function editTask(index) {
  const newTaskText = prompt("Edit your task:", tasks[index]);
  if (newTaskText !== null && newTaskText.trim() !== "") {
    tasks[index] = newTaskText.trim();
    renderTasks();
  }
}
