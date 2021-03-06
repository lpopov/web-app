var highlighter = {
    canvasEl: '',
    canvas: null,

    init: function(container) {
        this.canvasEl = container;
        this.canvas = document.getElementById(container);

        this.canvas.addEventListener('mouseup', function(evt) {
            handleSelectedText(evt);
        });

        this.canvas.addEventListener('keyup', function(evt) {
            handleSelectedText(evt);
        });
    },

    getMousePos: function(canvas, evt) {
        var rect = canvas.getBoundingClientRect();
        return {
            x: evt.clientX - rect.left,
            y: evt.clientY - rect.top
        };
    },

    showHighlighterMenu: function(coordX, coordY) {
        $('#imanee-highlighter-menu')
            .css({'top': coordY + 'px', 'left' : coordX + 'px' })
            .addClass('highlighter-menu-active')
        ;

        this.onSelectedText(getSelectionText());
    },

    hideHighlighterMenu: function() {
        $('#imanee-highlighter-menu')
            .removeClass('highlighter-menu-active')
        ;
    },

    onSelectedText: function(selectedText) {

    },

    onButtonClick: function(selectedText) {
    }
};

function handleSelectedText(evt) {
    var selectedText = getSelectionText();
    if (selectedText) {
        var mousePos = highlighter.getMousePos(highlighter.canvas, evt);
        highlighter.showHighlighterMenu($('.post-content').width() + 20, mousePos.y);
        //console.log('position:' + mousePos.x + ',' + mousePos.y);
        //alert("Got selected text " + selectedText);
    } else {
        highlighter.hideHighlighterMenu();
    }
}

function getSelectionText() {
    var text = "";
    if (window.getSelection) {
        text = window.getSelection().toString();
    } else if (document.selection && document.selection.type != "Control") {
        text = document.selection.createRange().text;
    }

    return text;
}