import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LeadFormComponent } from './components/lead-form/lead-form.component';
import { LeadsComponent } from './components/leads/leads.component';

const routes: Routes = [
  {
    path : '',
    component : LeadsComponent
  },

  {
    path : 'form',
    component : LeadFormComponent
  },

  {
    path : 'form/:id',
    component : LeadFormComponent
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
