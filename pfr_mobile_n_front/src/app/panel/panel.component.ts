import { Component, OnInit, Input, OnChanges } from '@angular/core';

@Component({
  selector: 'app-panel',
  templateUrl: './panel.component.html',
  styleUrls: ['./panel.component.scss'],
})
export class PanelComponent implements OnChanges {
  @Input() name: string;
  @Input() icone: string;
  @Input() index: number;
  @Input() home = false;
  data =
  {
    '--d-height': ['18%', '45%'],
    '--d-topimg': ['40%', '50%'],
    '--d-left' : ['38%', '31%'],
    '--d-i-width': ['60px', '110px'],
    '--d-i-height': ['70px', '120px'],
    '--ft-sz': ['14px', '18px'],
    '--d-top': ['79%', '87.8%']
  };
  constructor() {
  }

 changeHeight(index = 0){
  for (const el in this.data){
    if (el){
      // alert(this.data[el][index]);
      document.documentElement.style.setProperty(el, this.data[el][index]);
    }
  }
 }
  ngOnChanges(changes) {
    if (changes.index)
    {
     // alert(this.index);
      this.changeHeight(this.index);
    }
  }
}
