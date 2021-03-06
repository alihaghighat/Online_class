<style>
    .message-pop {
        position: fixed;
        display: none;
        width: 100%;
        height: 100%;
        z-index: 9999999;
        background-color: rgba(04, 50, 64, 0.7);
    }

    .message-content {
        border-radius: 0.5rem;
        width: 400px;
        min-height: 250px;
        background-color: #f0f0f0;
        margin: auto;
    }

    .message-body {
        height: 200px;
        padding: 0.5rem;
        padding-top: 1rem;
    }

    .message-buttons {
        float: left;
        bottom: 0;
        margin-left: 0.6rem;
    }

    .modal-header {
        direction: ltr !important;
    }

    /*end modal */

    .header-color {
        background-color: #02577a !important;
    }

    .member-person-icon-back {
        background-color: #32a8a2 !important;
    }

    .chat-person-back {
        background-color: #89d6fb !important;
    }

    .room-members-header-back {
        background-color: white;
    }

    .room-members-header-text {
        color: darkcyan;
    }

    .room-members-body-back {
        background-color: white;
    }

    .room-members-body-text {
        color: darkcyan;
    }

    .room-chats-header-back {
        background-color: #ededed;
    }

    .room-chats-header-text {
        color: darkolivegreen;
    }

    .room-chats-body-back {
        background-color: white;
    }

    .room-chats-body-text {
        color: black;
    }

    /* clock Style */

    .tabBlock {
        background-color: #57574f;
        border: solid 0px #ffa54f;
        border-radius: 5px;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        max-width: 200px;
        width: 100%;
        overflow: hidden;
        display: block;
        position: fixed;
        right: 5px;
    }

    .clock {
        vertical-align: middle;
        font-family: Orbitron;
        font-size: 30px;
        font-weight: normal;
        color: #fff;
        padding: 0 10px;
    }

    .clocklg {
        vertical-align: middle;
        font-family: Orbitron;
        font-size: 20px;
        font-weight: normal;
        color: #fff;
    }

    /* member card */
    .member-card {
        width: 96%;
        padding: 10px 5px;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        border-radius: 5px;
        margin-bottom: 2px;
        margin-top: 8px;

        background: #efefef;
    }

    .member-icon {
        padding: 5px;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        background: chocolate;
        color: white;
        font-size: 25px;
    }

    .member-name {
        padding: 0px 5px;
        flex: 1;
    }

    .member-access {
        font-size: 18px;
    }

    .kick-out-member {
        color: red;
        font-size: 14px;
    }

    .clear-chat-button:hover {
        cursor: pointer;
    }

    /*three sections */

    * {
        margin: 0;
        padding: 0;
    }

    body,
    html {
        height: 100%;
    }

    #myCanvas {
        cursor: crosshair;
        position: fixed;
        background-color: white;
        background-size: cover;
    }

    .main {
        display: flex;
        flex-direction: row;
        overflow: hidden;
        width: 100%;
    }

    .side-bar {
        overflow: hidden;
        width: 0px;
        height: 100%;
        background: #ccc;
        top: 0;
        right: 0;
        position: absolute;
        display: flex;
        flex-direction: column;
    }

    .close-side-bar-button-place {
        flex: 1;
        display: flex;
    }

    .close-side-bar-button {
        font-size: 30;
        color: white;
    }

    .close-side-bar-button:hover {
        animation: change-close-side-bar-button-color 0.2s forwards;
    }

    @keyframes change-close-side-bar-button-color {
        to {
            color: red;
        }
    }

    .page {
        width: 100%;
        height: 100%;
    }

    .header {
        padding: 5px;
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    .avatar {
        border-radius: 50%;
        width: 45px;
        height: 45px;
        background: white;
        border: 2px solid gray;
        margin-right: 5px;
    }

    .room-name {
        color: white;
    }

    .menu-button-place {
        flex: 1;
        display: flex;
        flex-direction: row-reverse;
    }

    .open-menu-button {
        font-size: 30px;
        color: white;
    }

    .header-control-buttons {
        margin-left: 4rem;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
    }

    .button-place {
        width: 40px;
        height: 30px;
        padding: 0 5px;
        overflow: hidden;
    }

    .control-button {
        color: indianred;
        font-size: 25px;
        cursor: pointer;
    }

    .control-button:hover {
        animation: control-button-hover 0.15s forwards;
    }

    #colorPicker {
        display: none;
    }

    @keyframes control-button-hover {
        from {
            font-size: 25px;
        }

        to {
            font-size: 30px;
        }
    }

    /*body content*/
    .body {
        padding: 10px;
    }

    .content-share {
        width: 100%;
        background: #fefefe;
        border-radius: 10px;
        overflow: hidden;
    }

    .content-share-header {
        width: 100%;
        height: 40px;
        padding: 4px 0 5px 5px;
        background: #eee;
        color: purple;
        font-size: 20px;
        font-weight: 600;
    }

    .content-share-body {
        width: 100%;
        height: 820px;
        background: white;
    }

    /*white board tool bar */

    /*end of white board tool*/

    .room-members {
        width: 100%;
        background: #fff;
        border-radius: 5px;
        overflow: hidden;
        margin-bottom: 15px;
    }

    .room-members-header {
        width: 100%;
        height: 40px;
        padding: 4px 0 5px 5px;
        font-size: 20px;
        font-weight: 600;
    }

    .room-members-body {
        width: 100%;
        height: 360px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /*chat box*/
    .room-chats {
        width: 100%;
        background: #fff;
        border-radius: 5px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .room-chats-header {
        width: 100%;
        height: 40px;
        padding: 4px 0 5px 5px;
        font-size: 20px;
        font-weight: 600;
    }

    .room-chats-body {
        width: 100%;
        display: flex;
        flex-direction: column;
        height: 360px;
        overflow-y: scroll;
        -ms-overflow-style: none;
        scrollbar-width: none;
        align-items: center;
    }

    .room-chats-body::-webkit-scrollbar {
        display: none;
    }

    .chat {
        margin: 5px;
        display: flex;
        flex-direction: column;
        border-radius: 10px;
        background: white;
        width: 96%;
        padding: 5px;
    }

    .chat-person-details {
        display: flex;
        flex-direction: row;
        width: 100%;
        align-items: center;
        padding-top: 8px;
    }

    .chat-person-icon {
        padding: 5px;
        font-size: 15px;
        border-radius: 50%;
        background: darkgoldenrod;
        color: whitesmoke;
        margin: 0px 6px;
    }

    .chat-text {
        margin-left: 15px;
        margin-top: 6px;
        font-size: 13px;
    }

    .chat-input-box {
        border-top: 1px solid #eee;

        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
    }

    .chat-input {
        border: none;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
        height: 40px;
        background: #efefef;
        width: 100%;
        padding-left: 5px;
    }

    .chat-input:focus {
        outline: none;
        box-shadow: none;
    }

    .send-text {
        color: #6f7580;
        border-radius: 5px;
        font-size: 25px;
        padding: 5px;
    }

    .send-text:hover {
        cursor: pointer;
        animation: send-text-hover 0.3s forwards;
    }

    @keyframes send-text-hover {
        to {
            background-color: #34b521;
            color: whitesmoke;
        }
    }

    /*end of chat box*/

    #divDraggable {
        display: none;
        border: dashed 1px #ccc;
        width: 120px;
        height: 120px;
        padding: 5px;
        margin: 5px;
        cursor: move;
        float: left;
        z-index: 999999;
        position: absolute;
    }

    .info {
        position: absolute;
    }

    /* in check_hozar.php style */

    .access-place:hover {
        animation: access-place-hover 0.3s forwards;
        cursor: pointer;
    }

    @keyframes access-place-hover {
        to {
            background-color: white;
        }
    }
</style>