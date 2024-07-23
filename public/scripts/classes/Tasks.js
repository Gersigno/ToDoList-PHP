/**
 * This class contain everything related to tasks
 */
class Tasks {
    #MSG_NO_TASKS = "You have no task(s)...";
    #ALL_TASKS_VISIBLE = false;

    /**
     * Toggle the visibility of every tasks present in the list (Show only the 5 firts by default).
     */
    setViewAllTasks() {
        this.#ALL_TASKS_VISIBLE = !this.#ALL_TASKS_VISIBLE;
        this.readTasks();
    }

    /**
     * Obtain and display user's tasks depending on the selected filter
     * (Probably need some refactoring xd)
     */
    async readTasks() {
        const ELEMENT_LIST = document.getElementById("list-container");
        const LABEL_AMOUNT = document.getElementById("task-amount");
        const THIS_CLASS = this;

        ELEMENT_LIST.innerHTML = '';
        LABEL_AMOUNT.innerHTML = 'Loading...';

        const CONTENT = await fetch("Tasks/getAll", REQUEST_OPTIONS);
        
        if(CONTENT.ok) {
            const RESPONSE = await CONTENT.json();
            const TASKS_AMOUNT = RESPONSE.length;
            
            let indexLimit;
            !this.#ALL_TASKS_VISIBLE ? indexLimit = 5 : indexLimit = 999999999;
            
            RESPONSE.forEach(task => {
                if(ELEMENT_LIST.children.length < indexLimit) {
                    let done_class = "";
                    let label_expiration = "";
                    let expiration_text = "";
                    let expiration_class = "";
                    
                    task['done'] == 1 ? done_class = " task-done" : undefined;

                    if(task['expiration_date'] != null) {
                        //Calculate the time left until the task expire.
                        const TIME_NOW = new Date();
                        const TIME_TASK = new Date(task['expiration_date']);
                        const TIME_MS_LEFT = TIME_TASK.getTime() - TIME_NOW.getTime();
                        var days = Math.floor(TIME_MS_LEFT / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((TIME_MS_LEFT % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((TIME_MS_LEFT % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((TIME_MS_LEFT % (1000 * 60)) / 1000);
                        expiration_text = "Expire in <b>" + days + "d " + hours + "h " + minutes + "m " + seconds + "s </b>";
                        if(TIME_MS_LEFT / (1000 * 60 * 60 * 24) < 1) {
                            //Less than a day left.
                                expiration_class = " task-expire-soon";
                                if(task['done'] == 0) {
                                    done_class += " task-expire-soon";
                                }
                        }
                        if(TIME_MS_LEFT < 0 ) {
                            //Task expired !
                            expiration_text = "Expired !";
                            expiration_class = " task-expired";
                            if(task['done'] == 0) {
                                done_class += " task-expired";
                            }
                        }
                    }
                    
                    (task['expiration_date'] != null && task['done'] == 0) ? label_expiration = "<span id='taskelem_"+ task['id'] +"_expire' class='task-expiration-label" + expiration_class + "'>" + expiration_text + "</span>" : undefined;
                    const ELEMENT_TASK = document.createElement("div");
                    ELEMENT_TASK.className = "task-element" + done_class;
                    ELEMENT_TASK.setAttribute("data-task-id", task['id']); //Set a dataset property on our html element to store the task's ID.
                    ELEMENT_TASK.innerHTML = `
                    <button class="task-button" onclick="TASKS.toggleDone(` + task['id'] + `)">
                    <h2>` + task['title'] + `</h2>
                    <h4>` + task['description'] + `</h4>
                    ` + label_expiration + `
                    </button>
                    <button class="btn-task-edit" onclick="Pop_EditTask(this)">
                        <img src="./resources/pen.png" alt="A pensil icon">
                    </button>
                    <button class="btn-task-remove" onclick="Pop_DeleteTask(this)">
                        <img src="./resources/bin.png" alt="A trashbin icon">
                    </button>`;

                    //Append the task depending on the selected filter and it's done status
                    if(selectedFilter == 'All') {
                        ELEMENT_LIST.appendChild(ELEMENT_TASK);
                    } else {
                        if(selectedFilter == 'Todo' && task['done'] == 0) {
                            ELEMENT_LIST.appendChild(ELEMENT_TASK);
                        } else if(selectedFilter == 'Done' && task['done'] == 1) {
                            ELEMENT_LIST.appendChild(ELEMENT_TASK);
                        }
                    }
                }
                
            });
            if(TASKS_AMOUNT > 5 && ELEMENT_LIST.children.length >= 5) {
                const BTN_SHOW_MORE = document.createElement("button");
                this.#ALL_TASKS_VISIBLE ? BTN_SHOW_MORE.innerHTML = "Show less" : BTN_SHOW_MORE.innerHTML = "Show more";
                BTN_SHOW_MORE.onclick = function () {
                    THIS_CLASS.setViewAllTasks();
                }
                ELEMENT_LIST.appendChild(BTN_SHOW_MORE);
            }
            
            //Update the task(s) amount text.
            const TEXT_NO_TASKS = "You have no task(s)...";
            let multiple_tasks = "";
            TASKS_AMOUNT > 1 ? multiple_tasks = "s" : null;
            TASKS_AMOUNT > 0 ? LABEL_AMOUNT.innerHTML = "You have a total of <b>" + TASKS_AMOUNT + "</b> task" + multiple_tasks : LABEL_AMOUNT.innerHTML = TEXT_NO_TASKS;
        } else {
            //On any fetch error
            LABEL_AMOUNT.innerHTML = '⚠️ Error ! Cannot read content ⚠️';
        }
        
    }

    /**
     * Toggle the done status of the intended task
     * @param {*} task_id Target task's ID
     */
    async toggleDone(task_id) {
        const CONTENT = await fetch("Tasks/switchDone/" + task_id, REQUEST_OPTIONS);
        if(CONTENT.ok) {
            const RESPONSE = await CONTENT.json();
            const ELEMENT_TASK = document.querySelector("[data-task-id=\"" + task_id + "\"]");
            // RESPONSE == 1 ? ELEMENT_TASK.children[0].className = "task-button task-done" : ELEMENT_TASK.children[0].className = "task-button";
            RESPONSE == 1 ? ELEMENT_TASK.className = "task-element task-done" : ELEMENT_TASK.children[0].className = "task-element";
            this.readTasks();
        }

    }

    /**
     * Delete the intended task.
     * @param {*} task_id Target task's ID
     */
    async delete(task_id) {
        const CONTENT = await fetch("Tasks/remove/" + task_id, REQUEST_OPTIONS);
        if(CONTENT.ok) {
            const RESPONSE = await CONTENT.json();
            document.getElementById("popup_elem").remove(); //Remove the confirmation popup of our user's screen.
            this.readTasks();
        }
    }

    /**
     * Return the expiration date of the intended task
     * @param {*} task_id 
     * @returns 
     */
    async getExpirationDate(task_id) {
        const CONTENT = await fetch("Tasks/getExpiration/" + task_id, REQUEST_OPTIONS);
        if(CONTENT.ok) {
            const RESPONSE = await CONTENT.json();
            return RESPONSE;
        }
    }
}