import { Chart } from "chart.js";

let chart =null;
export function statistikDompet(elementId,data){

    const canvas =document.getElementById(elementId)
    if(!canvas) return;
    if(chart){
        chart.destroy();
    }
    chart = new Chart(canvas,{
        type:'bar',
        data:{
            labels:data.map(item=>item.label),
            datasets:[{
                label:'Ayat Baru',
                data:data.map(item=>item.total),
                borderRadius:8,
                backgroundColor:'#dc2626'
            }]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false,
            plugins:{
                legend:{
                    display:false
                }
            },
            scales:{
                x:{
                    grid:{
                        display:false
                    }
                },
                y:{
                    beginAtZero:true,
                    ticks:{
                        precision:0
                    }
                }
            }
        }
    })
}
