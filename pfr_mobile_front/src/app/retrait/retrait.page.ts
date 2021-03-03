import { Component, OnDestroy } from '@angular/core';

@Component({
  selector: 'app-retrait',
  templateUrl: 'retrait.page.html',
  styleUrls: ['retrait.page.scss']
})
export class RetraitPage implements OnDestroy{

  constructor() {
    const tabBar = document.getElementById('myTab');
    tabBar.style.display = 'none';
  }

  ngOnDestroy(){

    const tabBar = document.getElementById('myTab');
    tabBar.style.display = '';
  }

}
