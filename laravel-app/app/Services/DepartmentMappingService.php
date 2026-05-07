<?php

namespace App\Services;

use App\Models\Department;

class DepartmentMappingService
{
    /**
     * Map complaint categories to departments
     */
    private static $categoryMapping = [
        'Water Supply' => 'Water Supply',
        'Electricity' => 'Electricity Department',
        'Road Maintenance' => 'Public Works',
        'Waste Management' => 'Sanitation Department',
        'Public Transport' => 'Transport Department',
        'Healthcare' => 'Health Department',
        'Education' => 'Education Department',
        'Public Safety' => 'Police Department',
        'Other' => 'General Administration',
    ];

    /**
     * Get department ID for a given category
     */
    public static function getDepartmentForCategory(string $category): ?string
    {
        $departmentName = self::$categoryMapping[$category] ?? null;
        
        if (!$departmentName) {
            return null;
        }

        $department = Department::where('name', $departmentName)->first();
        
        return $department ? $department->id : null;
    }

    /**
     * Get all category mappings
     */
    public static function getAllMappings(): array
    {
        return self::$categoryMapping;
    }

    /**
     * Create default departments if they don't exist
     */
    public static function createDefaultDepartments(): void
    {
        $departments = [
            'Water Supply' => 'Handles water supply and distribution complaints',
            'Electricity Department' => 'Manages electrical infrastructure and power supply issues',
            'Public Works' => 'Responsible for road maintenance and public infrastructure',
            'Sanitation Department' => 'Manages waste collection and sanitation services',
            'Transport Department' => 'Handles public transportation complaints',
            'Health Department' => 'Manages healthcare facility complaints',
            'Education Department' => 'Handles education-related complaints',
            'Police Department' => 'Manages public safety and security complaints',
            'General Administration' => 'Handles miscellaneous and general complaints',
        ];

        foreach ($departments as $name => $description) {
            Department::firstOrCreate(
                ['name' => $name],
                [
                    'email' => strtolower(str_replace(' ', '', $name)) . '@government.local',
                    'description' => $description
                ]
            );
        }
    }
}