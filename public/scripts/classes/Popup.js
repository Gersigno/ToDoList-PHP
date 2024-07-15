/**
 * Client-Side interface Popup
 */
class Popup {
    
    #ELEM_TITLE;
    #ELEM_CONTENT;
    
    constructor() {
        this.title = "";
        this.body = "";

        this.#buildPop();
    }

    /**
     * Set the title of the popup
     * @param {*} title Title
     */
    setTitle(title) {
        this.title = title;
        this.ELEM_TITLE.innerText = this.title;
    }

    /**
     * Set the HTML content of the popup
     * @param {*} content HTML-formated string
     */
    setContent(content) {
        this.body = content;
        this.ELEM_CONTENT.innerHTML = this.body;
    }

    /**
     * Private function
     * Build our pop-up interface
     */
    #buildPop() {
        let thisClass = this;

        var popup_elem = document.createElement("div")
        popup_elem.id = "popup_elem";
        popup_elem.className = "popup_element"
        // Page's background (blur)
        let background = document.createElement("div");
        background.className = "popup_background";
        background.id = "popup_background";
        
        background.onclick = function () {
            thisClass.close();
        }

        // Popup element
        let popup = document.createElement("div");
        popup.className = "popup";
        popup.id = "popup_content";

        // Header
        let header = document.createElement("div");
        header.className = "popup_header";
        // Popup title
        let title = document.createElement("h4");
        this.ELEM_TITLE = title;
        title.innerText = this.title;

        let close = document.createElement("button");
        close.innerText = "X";
        close.className = "popup_close";
        close.id = "popup_closeBtn"
        close.onclick = function () {
            // console.log("Close");
            thisClass.close();
        }

        // HTML content
        let content = document.createElement("div");
        this.ELEM_CONTENT = content;
        content.innerHTML = this.body;
        content.className = "popup_content";

        header.appendChild(title);
        header.appendChild(close);
        popup.appendChild(header);
        popup.appendChild(content);
        popup_elem.appendChild(background);
        popup_elem.appendChild(popup);
        document.body.appendChild(popup_elem);
    }

    /**
     * Will close/destroy the current popup
     */
    close() {
        document.getElementById("popup_elem").remove();
    }
}