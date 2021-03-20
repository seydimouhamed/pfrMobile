import { NgModule } from '@angular/core';
import { PreloadAllModules, RouterModule, Routes } from '@angular/router';
import { UseCurrentResolverService } from './resolvers/user-resolver.Service';

const routes: Routes = [
  {
    path: 'connexion',
    loadChildren: () => import('./connexion/connexion.module').then( m => m.ConnexionPageModule)
  },
  {
    path: 'tabs',
    loadChildren: () => import('./tabs/tabs.module').then(m => m.TabsPageModule),
    resolve: { currentUser : UseCurrentResolverService }
  },
  {
    path: 'screen',
    loadChildren: () => import('./screen/screen.module').then( m => m.ScreenPageModule)
  },
  {
    path: '',
    redirectTo: '/connexion',
    pathMatch: 'full'
  },
];
@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules })
  ],
  exports: [RouterModule]
})
export class AppRoutingModule {}
