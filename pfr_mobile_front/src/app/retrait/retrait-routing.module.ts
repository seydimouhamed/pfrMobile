import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { RetraitPage } from './retrait.page';

const routes: Routes = [
  {
    path: '',
    component: RetraitPage,
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class RetraitPageRoutingModule {}
