import { RouterModule } from '@angular/router';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { PanelComponent } from './panel.component';

@NgModule({
  imports: [ CommonModule,
    FormsModule,
    RouterModule,
    IonicModule],
  declarations: [PanelComponent],
  exports: [PanelComponent]
})
export class PanelComponentModule {}
