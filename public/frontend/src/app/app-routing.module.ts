import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes, CanActivate } from '@angular/router';

/*-----------------------------------------------------------------------
Inportando los Componentes
-----------------------------------------------------------------------*/
import { HomeComponent } from './components/public/home/home.component';
import { ServiceComponent } from './components/public/service/service.component';
import { SearchComponent } from './components/public/search/search.component';
import { LoginComponent } from './components/public/login/login.component';
import { PUserComponent } from './components/public/p-user/p-user.component';
import { PPerfilComponent } from './components/public/p-user/p-perfil/p-perfil.component';
/**
 * [componentes del Usuario]
 */
import { UserComponent } from './components/user/user.component';
import { PerfilComponent } from './components/user/perfil/perfil/perfil.component';
import { EditPerfilComponent } from './components/user/perfil/edit-perfil/edit-perfil.component';
import { CreateServiceComponent } from './components/user/service/create-service/create-service.component';
import { MyServicesComponent } from './components/user/service/my-services/my-services.component';
import { EditServiceComponent } from './components/user/service/edit-service/edit-service.component';
import { FavsComponent } from './components/user/service/favs/favs.component';
import { ConexionsComponent } from './components/user/conexions/conexions.component';
import { SettingsComponent } from './components/user/settings/settings.component';
import { CreateBudgetComponent } from './components/user/budget/create-budget/create-budget.component';
import { ViewBudgetComponent } from './components/user/budget/view-budget/view-budget.component';
import { RequestBudgetComponent } from './components/user/budget/request-budget/request-budget.component';
import { MyRequestsComponent } from './components/user/budget/request-budget/my-requests/my-requests.component';
import { CostumerComponent } from './components/user/costumer/costumer.component';
/**
 * Importamos el servicio
 */

import { AuthGuardService as AuthGuard } from './services/global/auth-guard/auth-guard.service';

const routes: Routes = [
  { path: '', component: HomeComponent},
  { path: 'service/:id', component: ServiceComponent},
  { path: 'search', component: SearchComponent},
  { path: 'login', component: LoginComponent},
  { path: 'p/:username/:status', component: PUserComponent},
  { path: 'usr', component:  UserComponent,
    children: [
      { path: '', component: PerfilComponent, canActivate: [AuthGuard]},
      { path: 'edit', component: EditPerfilComponent, canActivate: [AuthGuard]},
      { path: 'service/create', component: CreateServiceComponent, canActivate: [AuthGuard]},
      { path: 'service/edit/:id', component: EditServiceComponent, canActivate: [AuthGuard]},
      { path: 'my-services', component: MyServicesComponent, canActivate: [AuthGuard]},
      { path: 'costumers', component: CostumerComponent, canActivate: [AuthGuard]},
      { path: 'favs-services', component: FavsComponent, canActivate: [AuthGuard]},
      { path: 'conexions', component: ConexionsComponent, canActivate: [AuthGuard]},
      { path: 'settings', component: SettingsComponent, canActivate: [AuthGuard]},
      { path: 'budget/create', component: CreateBudgetComponent, canActivate: [AuthGuard]},
      { path: 'budget/w', component: ViewBudgetComponent, canActivate: [AuthGuard]},
      { path: 'budget/request', component: RequestBudgetComponent, canActivate: [AuthGuard]},
      { path: 'budget/my-request', component: MyRequestsComponent, canActivate: [AuthGuard]},
      { path: '**', redirectTo: '', pathMatch: 'full' }
    ]
  },
  { path: '**', redirectTo: '', pathMatch: 'full' }

];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
