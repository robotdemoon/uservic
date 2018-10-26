/**
 * [Modulos Base]
 */

import { NgModule } from '@angular/core';
import { FormsModule, ReactiveFormsModule} from '@angular/forms';
import { BrowserModule } from '@angular/platform-browser';
import { HttpModule } from '@angular/http';
import { AppRoutingModule } from './app-routing.module';

/**
 * [Componentes Publicos]
 */

 //Componentes Base
import { AppComponent } from './app.component';
import { HomeComponent } from './components/public/home/home.component';
import { HeaderComponent } from './components/base/header/header.component';
import { NavleftComponent } from './components/base/navleft/navleft.component';

//Componentes Publicos no Base

import { ServiceComponent } from './components/public/service/service.component';
import { ServiceCommentsComponent } from './components/public/service/service-comments/service-comments.component';
import { ServiceSuggestedComponent } from './components/public/service/service-suggested/service-suggested.component';
import { SearchComponent } from './components/public/search/search.component';
import { LoginComponent } from './components/public/login/login.component';
import { PUserComponent } from './components/public/p-user/p-user.component';
import { PPerfilComponent } from './components/public/p-user/p-perfil/p-perfil.component';
/**
 * [Importamos las Directivas y/o scripts]
 */

import { ClickOutside } from './directives/click-outside.directive';
import { InfiniteScrollModule } from 'ngx-infinite-scroll';
import { DefaultImage } from './directives/image-exist.directive';

/**
 * [Importamos los componentes del Usuario]
 */

import { PerfilComponent } from './components/user/perfil/perfil/perfil.component';
import { EditPerfilComponent } from './components/user/perfil/edit-perfil/edit-perfil.component';
import { UserComponent } from './components/user/user.component';
import { CreateServiceComponent } from './components/user/service/create-service/create-service.component';
import { MyServicesComponent } from './components/user/service/my-services/my-services.component';
import { EditServiceComponent } from './components/user/service/edit-service/edit-service.component';
import { FavsComponent } from './components/user/service/favs/favs.component';
import { ConexionsComponent } from './components/user/conexions/conexions.component';
import { SettingsComponent } from './components/user/settings/settings.component';
import { PServiceComponent } from './components/public/p-user/p-service/p-service.component';
import { CreateBudgetComponent } from './components/user/budget/create-budget/create-budget.component';
import { ViewBudgetComponent } from './components/user/budget/view-budget/view-budget.component';
import { RequestBudgetComponent } from './components/user/budget/request-budget/request-budget.component';
import { MyRequestsComponent } from './components/user/budget/request-budget/my-requests/my-requests.component';
import { CostumerComponent } from './components/user/costumer/costumer.component';

@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    /**
     * Importamos las Directivas 
    */
    ClickOutside,
    DefaultImage,
    HeaderComponent,
    NavleftComponent,
    ServiceComponent,
    ServiceCommentsComponent,
    ServiceSuggestedComponent,
    SearchComponent,
    LoginComponent,
    PerfilComponent,
    EditPerfilComponent,
    UserComponent,
    CreateServiceComponent,
    MyServicesComponent,
    EditServiceComponent,
    FavsComponent,
    ConexionsComponent,
    SettingsComponent,
    PUserComponent,
    PPerfilComponent,
    PServiceComponent,
    CreateBudgetComponent,
    ViewBudgetComponent,
    RequestBudgetComponent,
    MyRequestsComponent,
    CostumerComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    InfiniteScrollModule,
    ReactiveFormsModule,
    HttpModule,
    AppRoutingModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
