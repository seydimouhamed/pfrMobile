import { TransactionCUResolverService, TransactionAgenceResolverService, CommissionAgenceResolverService } from './../resolvers/transaction-resolver.service';
import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomePage } from './home.page';

const routes: Routes = [
  {
    path: '',
    component: HomePage,
    children: [
    ]
  },
  {
    path: 'depot',
    loadChildren: () => import('../depot/depot.module').then(m => m.DepotPageModule)
  },
  {
    path: 'retrait',
    loadChildren: () => import('../retrait/retrait.module').then(m => m.RetraitPageModule)
  },
  {
    path: 'commission',
    loadChildren: () => import('../commission/commission.module').then(m => m.CommissionPageModule),
    resolve: { transactions: CommissionAgenceResolverService}
  },
  {
    path: 'transaction',
    loadChildren: () => import('../transaction/transaction.module').then(m => m.TransactionPageModule),
    resolve: { transactions: TransactionCUResolverService}
  },
  {
    path: 'allTransaction',
    loadChildren: () => import('../allTransaction/allTransaction.module').then(m => m.AllTransactionPageModule),
    resolve: { transactions: TransactionAgenceResolverService}
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class HomePageRoutingModule {}
