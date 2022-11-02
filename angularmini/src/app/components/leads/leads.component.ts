import { Component, OnInit } from '@angular/core';
import { Lead } from 'src/app/models/lead';
import { LeadService } from 'src/app/services/lead.service';

@Component({
  selector: 'app-leads',
  templateUrl: './leads.component.html',
  styleUrls: ['./leads.component.sass']
})
export class LeadsComponent implements OnInit {

  leads : Lead[];
  
  constructor(
    private leadService : LeadService
  ) { }

  ngOnInit(): void {
    this.getLeads();
  }
  getLeads() {
    this.leadService.getLeads().subscribe((data : Lead[]) => {
      this.leads = data;
    });
  }

}
