//This array is used to build our filter's buttons
const FILTERS = new Array("All", "To do", "Done");
//We then create an empty variable that will later be set to our current selected filter.
let selectedFilter;
//Create an instance of our Tasks class
const TASKS = new Tasks();

//Our fetchs request options
const REQUEST_OPTIONS = {
  method: 'POST',
  body: JSON.stringify({
    action: "GET"
  }),
  headers: {
    "Content-Type": "application/json; charset=UTF-8",
    'credentials': 'same-origin',
    'X-Requested-With': 'XMLHttpRequest'
  }
}

/**
 * Initialize our interface when our page is fully loaded
 */
function initInterface() {
  buildFilters();
  updateFilters();
}

/**
 * This function updates the selected filter when any filter button is pressed by the user (Default: **ALL**)
 * @param {*} targetButton This parameter **NEED** to be a button containing a filter present in our filters list array ("*filters*") as an **ID without spaces**.
 */
function updateFilters(targetButton = document.getElementById("filters-container").children[0]) {
  //We obtain our button's ID, that is actually our filter's name WITHOUT SPACE.
  selectedFilter = targetButton.id;

  const CONTAINER = document.getElementById("filters-container");
  for (let child of CONTAINER.children) {
    //First, we remove the "buttonSelected" class of each button.
    child.classList.remove("filter-selected");
  }
  const ACTIVE_BUTTON = document.getElementById(selectedFilter);
  //Then, we add it back to the selected filter's button
  ACTIVE_BUTTON.classList.add("filter-selected");
  //Finally we update our list.
  TASKS.readTasks();
}

/**
 * Build our filter's buttons with our "filters" array variable
 */
function buildFilters() {
  //We first obtain our container element from our html by his ID.
  const CONTAINER = document.getElementById("filters-container");
  //Then, for each filter, we create a new button
  for (let filter in FILTERS) {
    const BUTTON = document.createElement("button");
    //! Don't forget that we remove any white spaces from our filter's name to set it as our button's ID.
    BUTTON.id = FILTERS[filter].replace(" ", "");
    BUTTON.innerText = FILTERS[filter];
    BUTTON.onclick = function (e) {
      //We set our button (using this) as a parameter to later obtain his ID, aka, our selected filter's name WITHOUT SPACES.
      return updateFilters(this);
    };
    //Finally, we append our new button to our container.
    CONTAINER.appendChild(BUTTON);
  }
}

/**
 * Bring the "Add a new task" Popup to our user's screen.
 */
function Pop_CreateTask() {
  let popup = new Popup();
  popup.setTitle("💼 Add a new task");
  popup.setContent(`
    <form action="#" method="post" id="form_newtask">
        <h5>Title*</h5>
        <input type="text" id="newtask_title" name="title" maxlength="50">
        <h5>Description*</h5>
        <textarea maxlength="255" id="temp_desc"></textarea>
        <input type="text" id="newtask_desc" name="desc" hidden>
        <h5>Expiration date <i>(Optional)</i></h5>
        <input type="checkbox" id="is_expirable" name="newtask_use_expire">
        <input type="datetime-local" name="expiration" id="newtask_expiration" hidden>
        <br>
        <input type="submit" class="btn btn-action btn-big" id="newtask_submit" disabled="true">
    </form>
  `);

  const FORM = document.getElementById("form_newtask");
  const INPUT_TITLE = document.getElementById("newtask_title");
  const INPUT_DESC = document.getElementById("newtask_desc");
  const TEMP_DESC = document.getElementById("temp_desc");
  const INPUT_EXPIRE_CHECKBOX = document.getElementById("is_expirable");
  const INPUT_EXPIRE_DATE = document.getElementById("newtask_expiration");
  const BTN_SUBMIT = document.getElementById("newtask_submit");

  const CURRENT_TIME = new Date();
  CURRENT_TIME.setMinutes(CURRENT_TIME.getMinutes() - CURRENT_TIME.getTimezoneOffset());
  INPUT_EXPIRE_DATE.value = CURRENT_TIME.toISOString().slice(0,16);

  //Prevent the Enter key to send to form
  FORM.onkeydown = function (event) {
    if (event.keyCode === 13) {
      return false;
    }
  }  

  //Prevent new line on Enter key down
  INPUT_TITLE.onkeydown = function (event) {
    if (event.keyCode === 13) {
      event.preventDefault();
    }
  }

  //Show/Hide the date-time selection 
  INPUT_EXPIRE_CHECKBOX.onclick = function () {
    INPUT_EXPIRE_CHECKBOX.checked ? INPUT_EXPIRE_DATE.hidden = false : INPUT_EXPIRE_DATE.hidden = true;
  }

  //On any text inputs, we check if our submit button should be enabled or not.
  INPUT_TITLE.oninput = function () {
    (INPUT_TITLE.value != "" && TEMP_DESC.value != "") ? BTN_SUBMIT.disabled = false : BTN_SUBMIT.disabled = true;
  }
  TEMP_DESC.oninput = function () {
    (INPUT_TITLE.value != "" && TEMP_DESC.value != "") ? BTN_SUBMIT.disabled = false : BTN_SUBMIT.disabled = true;
  }

  //On form submit, set the input description to the temporary description textarea's value.
  FORM.onsubmit = function () {
    !INPUT_EXPIRE_CHECKBOX.checked ? INPUT_EXPIRE_DATE.value = "" : null;
    INPUT_DESC.value = TEMP_DESC.value;
  }
}

/**
 * Bring the "Add a new task" Popup to our user's screen.
 */
function Pop_DeleteTask(elem_task) {
  const TASK_ID = parseInt(elem_task.parentNode.dataset.taskId);
  const TASK_NAME = elem_task.parentNode.children[0].children[0].innerText;
  let popup = new Popup();
  popup.setTitle("⚠️ Warning !");
  popup.setContent(`
    <br>
    <p>Are you sure to remove the task <b>"` + TASK_NAME + `"</b></p><br>
    <button id="remove_task" onclick="TASKS.delete(` + TASK_ID + `)" class="btn-danger">Delete</button>
    <button id="cancel_popup">Cancel</button>
  `);
  document.getElementById("cancel_popup").onclick = function () {
    document.getElementById("popup_elem").remove();
  }
}

async function Pop_EditTask(elem_task) {
  const TASK_ID = parseInt(elem_task.parentNode.dataset.taskId);
  const TASK_NAME = elem_task.parentNode.children[0].children[0].innerText;
  const TASK_DESCRIPTION = elem_task.parentNode.children[0].children[1].innerText;
  let popup = new Popup();
  popup.setTitle("✒️ Task editor !");
  popup.setContent(`
    <form action="#" method="post" id="form_edittask">
      <input type="number" name="task_id"hidden value="`+ TASK_ID +`">
        <h5>Title*</h5>
        <input type="text" id="edittask_title" name="title" maxlength="50" value="` + TASK_NAME + `">
        <h5>Description*</h5>
        <textarea maxlength="255" id="temp_desc">` + TASK_DESCRIPTION + `</textarea>
        <input type="text" id="edittask_desc" name="desc" hidden>
        <h5>Expiration date <i>(Optional)</i></h5>
        <input type="checkbox" id="is_expirable" name="edittask_use_expire">
        <input type="datetime-local" name="expiration" id="edittask_expiration" hidden>
        <br>
        <input type="submit" type="edit_submit" class="btn btn-action btn-big" id="edittask_submit"value="Update">
    </form>
  `);

  const FORM = document.getElementById("form_edittask");
  const INPUT_TITLE = document.getElementById("edittask_title");
  const INPUT_DESC = document.getElementById("edittask_desc");
  const TEMP_DESC = document.getElementById("temp_desc");
  const INPUT_EXPIRE_CHECKBOX = document.getElementById("is_expirable");
  const INPUT_EXPIRE_DATE = document.getElementById("edittask_expiration");
  const BTN_SUBMIT = document.getElementById("edittask_submit");
  const TASK_EXPIRATION_DATE = document.getElementById("taskelem_"+ TASK_ID +"_expire");

  const CURRENT_TIME = new Date();
  CURRENT_TIME.setMinutes(CURRENT_TIME.getMinutes() - CURRENT_TIME.getTimezoneOffset());
  if(TASK_EXPIRATION_DATE != undefined) {
    INPUT_EXPIRE_CHECKBOX.checked = true;
    const TASK_EXPIRATION = await TASKS.getExpirationDate(TASK_ID);
    INPUT_EXPIRE_DATE.value = TASK_EXPIRATION;
  } else {
    INPUT_EXPIRE_CHECKBOX.checked = false;
    INPUT_EXPIRE_DATE.value = CURRENT_TIME.toISOString().slice(0,16);
  }

  //Prevent the Enter key to send to form
  FORM.onkeydown = function (event) {
    if (event.keyCode === 13) {
      return false;
    }
  }  

  //Prevent new line on Enter key down
  INPUT_TITLE.onkeydown = function (event) {
    if (event.keyCode === 13) {
      event.preventDefault();
    }
  }
  
  INPUT_EXPIRE_CHECKBOX.checked ? INPUT_EXPIRE_DATE.hidden = false : INPUT_EXPIRE_DATE.hidden = true;

  //Show/Hide the date-time selection 
  INPUT_EXPIRE_CHECKBOX.onclick = function () {
    INPUT_EXPIRE_CHECKBOX.checked ? INPUT_EXPIRE_DATE.hidden = false : INPUT_EXPIRE_DATE.hidden = true;
  }

  //On any text inputs, we check if our submit button should be enabled or not.
  INPUT_TITLE.oninput = function () {
    (INPUT_TITLE.value != "" && TEMP_DESC.value != "") ? BTN_SUBMIT.disabled = false : BTN_SUBMIT.disabled = true;
  }
  TEMP_DESC.oninput = function () {
    (INPUT_TITLE.value != "" && TEMP_DESC.value != "") ? BTN_SUBMIT.disabled = false : BTN_SUBMIT.disabled = true;
  }

  //On form submit, set the input description to the temporary description textarea's value.
  FORM.onsubmit = function () {
    !INPUT_EXPIRE_CHECKBOX.checked ? INPUT_EXPIRE_DATE.value = "" : null;
    INPUT_DESC.value = TEMP_DESC.value;
  }
}