import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-explore-container',
  templateUrl: './explore-container.component.html',
  styleUrls: ['./explore-container.component.scss'],
})
export class ExploreContainerComponent implements OnInit {
  @Input() name: string;
  @Input() icone: string;
  @Input() height: string;

  constructor() {
    this.changeHeight( 'grand');
  }
 changeHeight(height){
  document.documentElement.style.setProperty('--dynamic-height', height);
 }
  ngOnInit() {}

}
