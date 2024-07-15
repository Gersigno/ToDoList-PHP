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
 * Bring the account delete confirmation pop-up to the user's screen
 */
function Pop_DeleteAccount() {
    let popup = new Popup();
    popup.setTitle("⚠️ Warning !");
    popup.setContent(`
    <br>
    <p>Are you sure to delete your account ?</p>
    <p>This action is <b>permanent</b> !</p><br>
    <button id="remove_task" onclick="deleteMyAccount()" class="btn-danger">Delete</button>
    <button id="cancel_popup">Cancel</button>
  `);
    document.getElementById("cancel_popup").onclick = function () {
        document.getElementById("popup_elem").remove();
    }
}

/**
 * Will try to delete every tasks owned by the current logged user and then delete the user it-self
 * Response return 0 on any error.
 */
async function deleteMyAccount() {
    const CONTENT = await fetch("Profile/DeleteMyAccount", REQUEST_OPTIONS);
    const RESPONSE = await CONTENT.json();
    if (RESPONSE == 1 && CONTENT.ok) {
        window.location.href = "/logout";
    }
}