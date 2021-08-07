<style>
    #mainCanvas {
        background: white;
    }

    #canvas-container {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #colorPicker {
        position: fixed;
        display: none;
        left: 90px;
        margin-top: -25px;


    }


    /*white board tool bar */
    .white-board-tool {
        margin-top: 10px;
        position: fixed;
        width: 70px;
        border-radius: 5px;
        background: #fafafa;
        z-index: 9;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        margin-left: 10px;

    }

    .tool-icon {
        width: 100%;
        text-align: center;
        justify-content: center;
        align-items: center;
        padding: 5px 0;
        background: #eee;
        cursor: move;

    }

    .white-board-tool-buttons {
        display: none;
        flex-direction: column;
    }

    .white-board-tool-button {
        font-size: 25px;
        width: 70px;
        padding: 15px 0;
        height: 30px;
        text-align: center;
        overflow: hidden;
        border-radius: 4px;
        height: 60px;
    }

    .white-board-tool-button:hover {
        animation: white-board-tool-button-hover .2s forwards;
        cursor: pointer;
    }

    .tool-toggle-button {
        font-size: 20px;
        text-align: center;
        background: #eee;

    }

    .tool-toggle-button:hover {
        animation: white-board-tool-button-hover .2s forwards;
        cursor: pointer;
    }

    .white-board-color-picker {
        position: fixed;
        margin-left: 40px;
        z-index: 9999;
    }

    /*tool toggle animation */
    @keyframes fullRotate {
        to {
            transform: rotate(180deg);
        }
    }

    @keyframes backRotate {
        from {
            transform: rotate(180deg);
        }

        to {
            transform: rotate(0deg);
        }
    }

    @keyframes white-board-tool-button-hover {
        to {
            font-size: 30px;
            background: #aaa;
        }


    }


    .all-shapes {
        position: fixed;
        display: none;
        left: 90px;
        margin-top: -45px;
        padding: 5px;
        border-radius: 5px;
        background-color: #fafafa;
    }

    .text-size-slider {
        display: none;
        position: fixed !important;
        background-color: #eee;
        height: 30px;
        left: 90px;
        margin-top: -45px;

        justify-content: center;
        align-items: center;
        padding: 5px;
        border-radius: 5px;
    }

    .draw-size-place {
        display: none;
        position: fixed !important;
        background-color: #eee;
        height: 30px;
        left: 90px;
        margin-top: -45px;

        justify-content: center;
        align-items: center;
        padding: 5px;
        border-radius: 5px;
    }

    /*end of white board tool*/

    .pdf-tool {
        bottom: 20px;
        position: fixed;
        background-color: #eee;
        display: flex;
        flex-direction: row;
        padding: 5px;
        border-radius: 5px;
        left: 600px;
        align-items: center;

    }

    .new-file-upload {
        padding: 5px;
        border-radius: 3px;
    }

    .new-file-upload:hover {
        animation: change-background-upload-icon .4s forwards;
    }

    @keyframes change-background-upload-icon {
        from {
            background-color: #eee;
        }

        to {
            background-color: #aaa;
        }
    }

    .hover-pointer:hover {
        cursor: pointer;

    }
</style>