<div id="TimedBarParent" class="fixed-top">
    <div id="TimedBarOutline">
        <div id="TimedBar"></div>
        <div class="inner-outline">
            <div>IN</div>
            <div>BACK</div>
            <div>NEXT</div>
            <div>PREV</div>
            <div>REST</div>
        </div>
    </div>
    <div id="clickZone">

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script>
    $(document).ready(()=>{
        let width=0;
        let distance = 1;
        let time = 50;
        setInterval(()=>{
            width=(width+distance)%100;
            $('#TimedBar').css('width',width+"%");
        },time);

        let pageQueue = [];

        const removeHightLight = ()=>{
            $(document).find('#highlighter').remove();
        }
        const addHighLight = ()=>{
            $(pageQueue[pageQueue.length-1]).after('<div id="highlighter"></div>')
            let top = $(pageQueue[pageQueue.length-1]).parent().offset().top;
            $(document.body).scrollTop($(pageQueue[pageQueue.length-1]).parent().offset().top);
            window.scrollTo({
                top:top-200,
                behavior:"smooth"
            })
        }

        const push = (ele)=>{
            removeHightLight();
            pageQueue.push(ele);
            addHighLight();
        }
        const pop = ()=>{
            removeHightLight();
            pageQueue.pop();
            addHighLight();
        }

        const goIN = ()=>{
            let parent = $(pageQueue[pageQueue.length-1]).parent()
            let anchors = parent.find(".anchor");
            if(anchors.length>1){
                push(anchors[1]);
            }
            else{
                parent[0].click();
            }
        }
        const goBack = ()=>{
            if (pageQueue.length>1){
                pop()
            }
        }
        const goNext = ()=>{
            if(pageQueue.length>1){
                let currAnchor = pageQueue[pageQueue.length-1];
                let parentAnchor = pageQueue[pageQueue.length-2]
                let anchorsParO = $(parentAnchor).parent().find(".anchor");
                let anchorsCurO = $(currAnchor).parent().find(".anchor");
        

                let anchorsPar = [];
                for(let i = 0;i<anchorsParO.length;i++)anchorsPar.push(anchorsParO[i]);

                let anchorsCur = [];
                for(let i = 1;i<anchorsCurO.length;i++)anchorsCur.push(anchorsCurO[i]);
                
                let difference = anchorsPar.filter(x => !anchorsCur.includes(x));
                let currIndex = difference.indexOf(currAnchor);
                if(currIndex+1!=difference.length){
                    pop()
                    push(difference[currIndex+1]);
                }
            }
        }
        const goPrev = ()=>{
            if(pageQueue.length>1){
                let currAnchor = pageQueue[pageQueue.length-1];
                let parentAnchor = pageQueue[pageQueue.length-2]
                let anchorsParO = $(parentAnchor).parent().find(".anchor");
                let anchorsCurO = $(currAnchor).parent().find(".anchor");
        

                let anchorsPar = [];
                for(let i = 0;i<anchorsParO.length;i++)anchorsPar.push(anchorsParO[i]);

                let anchorsCur = [];
                for(let i = 1;i<anchorsCurO.length;i++)anchorsCur.push(anchorsCurO[i]);
                
                let difference = anchorsPar.filter(x => !anchorsCur.includes(x));
                let currIndex = difference.indexOf(currAnchor);
                if(currIndex-1!=-1){
                    pop()
                    push(difference[currIndex-1]);
                }
            }
        }


        pageQueue.push($(document.body).find(".anchor")[0]);
        addHighLight();


        $('#clickZone').click(()=>{
            if(width<20){
                goIN();
                width=0;
            }
            else if(width<40){
                goBack();
                width=0;

            }
            else if(width<60){
                goNext();
                width=0;
            }
            else if(width<80){
                goPrev();
                width=0;
            }
            else{

            }
        })

    })
        
</script>

